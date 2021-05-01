<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Message extends Mailable
{
    use Queueable, SerializesModels;

    public $message_nrh;
    public $objet;
    public $email;

    /**
     * Create a new message instance.
     *
     * @param $message
     * @param $objet
     * @param $email
     */
    public function __construct($message, $objet, $email)
    {
        //
        $this->message_nrh = $message;
        $this->objet   = $objet;
        $this->email = $email;

        # dd($message, $objet, $email);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email)
            ->subject($this->objet)
            ->view('emails.message')->with([
                            'message_nrh' => $this->message_nrh,
                            'email'   => $this->email,
                        ])
            ;
    }
}
