<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Successful Registration – Dagupan City National High School SRIS',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration-approved',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}