<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GuestWelcome extends Mailable
{
    use Queueable, SerializesModels;


    var $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.guestWelcome')
        ->subject("Welcome to Jollof.com")
        ->with([
            'firstName' => $this->user['first_name'],
            'lastName' => $this->user['last_name'],
            'address' => $this->user['address'],
            'email' => $this->user['email'],
            'password' => $this->user['password'],
        ]);
    }
}
