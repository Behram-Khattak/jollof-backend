<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Email data.
     */
    protected $contact;

    /**
     * Create a new message instance.
     *
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->contact = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Contact form Message';

        return $this->markdown('emails.contact')
            ->subject($subject)
            ->with($this->contact);
    }
}
