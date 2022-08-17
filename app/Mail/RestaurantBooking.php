<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RestaurantBooking extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Email data.
     */
    protected $booking;

    /**
     * Create a new message instance.
     *
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->booking = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Restaurant table booking from  '.$this->booking['first_name'].' '.$this->booking['last_name'];

        return $this->markdown('emails.bookings.restaurant')
            ->subject($subject)
            ->with($this->booking);
    }
}
