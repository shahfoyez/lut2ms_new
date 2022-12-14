<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChatResponse extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

      /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->data['token'])
                    ->markdown('emails.chatResponse');

    }

    public function envelope()
    {
        return new Envelope(
            subject: $this->data['token'],
        );
    }

    // public function content()
    // {
    //     return new Content(
    //         view: 'email.chatResponse',
    //     );
    // }


    // public function attachments()
    // {
    //     return [];
    // }
}
