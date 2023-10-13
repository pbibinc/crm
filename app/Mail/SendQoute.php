<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendQoute extends Mailable
{
    use Queueable, SerializesModels;

    public $qoutedMailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($qoutedMailData)
    {
        //
        $this->qoutedMailData = $qoutedMailData;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Send Qoute',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mail.qoutation-email-template',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    // public function build()
    // {
    //     return $this->subject('Sample Qoutation')
    //                 ->view('mail.qoutation-email-template');
    // }
}
