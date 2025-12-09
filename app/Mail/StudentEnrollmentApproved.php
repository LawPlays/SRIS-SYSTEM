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

class StudentEnrollmentApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $enrollment;

    /**
     * Create a new message instance.
     */
    public function __construct(User $student, Enrollment $enrollment)
    {
        $this->student = $student;
        $this->enrollment = $enrollment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 Congratulations! Your Enrollment has been Approved - SRIS',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.student-enrollment-approved',
            with: [
                'student' => $this->student,
                'enrollment' => $this->enrollment,
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
        return [];
    }
}
