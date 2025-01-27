<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $userId;

    /**
     * Create a new message instance.
     * 
     * @return void
     */
    public function __construct($token, $userId)
    {
        $this->token = $token;
        $this->userId = $userId;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reset_password',
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

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Resetovanje lozinke')
            ->view('emails.reset_password')
            ->with([
                'token' => $this->token,
                'userId' => $this->userId,
            ]);
    }
}


    //  public function build()
    //  {
    //      return $this->subject('Resetovanje lozinke')
    //          ->view('emails.reset_password') 
    //          ->with([
    //              'token' => $this->token,
    //              'userId' => $this->userId
    //          ]);
    //  }

    //  public function build()
    // {
    //     $resetUrl = url("http://localhost:3000/ResetPassword" . $this->token);

    //     return $this->view('emails.reset_password')
    //                 ->with(['resetUrl' => $resetUrl]);
    // }



    // public function build()
    // {
    //     return $this->view('emails.reset_password')
    //         ->with([
    //             'token' => $this->token,
    //         ]);
    // }

