<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PayForMe extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Email data.
     */
    protected $payme;

    /**
     * Create a new message instance.
     *
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->payme = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Pay For me from '.$this->payme['sender'];

        return $this->markdown('emails.orders.payforme')
            ->subject($subject)
            ->with($this->payme);
    }
}
