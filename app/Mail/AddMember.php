<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AddMember extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $password, public string $resetToken)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to '. config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.add-member',
            with: [
                'user' => $this->user,
                'password' => $this->password,
                'resetToken' => $this->resetToken,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}