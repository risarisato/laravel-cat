<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public array $contactInfo)
    {
        //
    }

    /**
     * Get the message envelope.
     * envelopeはメールの差出人や件名を指定するメソッド
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            //from: 'user@example.com',
            from: new Address($this->contactInfo['email'], $this->contactInfo['name']),
            subject: 'お問い合わせがありました',
        );
    }

    /**
     * Get the message content definition.
     * contentはメールの本文を指定するメソッド
     */
    public function content(): Content
    {
        return new Content(
            text:'emails.contact.admin',
        );
    }

    /**
     * Get the attachments for the message.
     * attachmentsは添付ファイルを指定するメソッド
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
