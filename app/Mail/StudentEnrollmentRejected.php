<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class StudentEnrollmentRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $enrollment;
    public $missingRequirements;

    /**
     * Create a new message instance.
     */
    public function __construct(User $student, Enrollment $enrollment, array $missingRequirements = [])
    {
        // Load documents relationship to include uploaded files in email
        $this->student = $student->load('documents');
        $this->enrollment = $enrollment;
        $this->missingRequirements = $missingRequirements;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📋 Action Required: Missing Requirements for Your Enrollment - SRIS',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.student-enrollment-rejected',
            with: [
                'student' => $this->student,
                'enrollment' => $this->enrollment,
                'missingRequirements' => $this->missingRequirements,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        $attachedPaths = [];

        // Add Form 137 if uploaded
        if ($this->enrollment->form137 && \Storage::disk('public')->exists($this->enrollment->form137)) {
            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromStorageDisk('public', $this->enrollment->form137)
                ->as('Form_137_Report_Card.' . pathinfo($this->enrollment->form137, PATHINFO_EXTENSION));
            $attachedPaths[$this->enrollment->form137] = true;
        }

        // Add PSA Birth Certificate if uploaded
        if ($this->enrollment->psa_birth_certificate && \Storage::disk('public')->exists($this->enrollment->psa_birth_certificate)) {
            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromStorageDisk('public', $this->enrollment->psa_birth_certificate)
                ->as('PSA_Birth_Certificate.' . pathinfo($this->enrollment->psa_birth_certificate, PATHINFO_EXTENSION));
            $attachedPaths[$this->enrollment->psa_birth_certificate] = true;
        }

        // Determine level tag for filtering (JHS/SHS)
        $grade = $this->enrollment->grade_level ?? null;
        $isJHS = in_array($grade, ['Grade 7','Grade 8','Grade 9','Grade 10']);
        $isSHS = in_array($grade, ['Grade 11','Grade 12']);
        $levelTag = $isJHS ? 'JHS' : ($isSHS ? 'SHS' : null);

        // Add additional documents uploaded by student (deduplicated and level-filtered)
        foreach ($this->student->documents as $document) {
            $path = $document->file_path;
            if (!\Storage::disk('public')->exists($path)) continue;

            // Skip if already attached by enrollment files
            if (isset($attachedPaths[$path])) continue;

            // Apply level filter: include only matching tag or untagged
            $name = $document->file_name ?? '';
            if ($levelTag) {
                $hasLevelTag = str_contains($name, ' - ' . $levelTag);
                $hasOtherTag = str_contains($name, ' - JHS') || str_contains($name, ' - SHS');
                if (!$hasLevelTag && $hasOtherTag) continue;
            }

            $fileName = str_replace(' ', '_', $name) . '.' . $document->file_type;
            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromStorageDisk('public', $path)
                ->as($fileName);
            $attachedPaths[$path] = true;
        }

        return $attachments;
    }
}
