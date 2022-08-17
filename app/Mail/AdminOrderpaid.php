<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Enums\JollofEmails;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminOrderPaid extends Mailable // implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * Email data.
     */
    protected $order;

    /**
     * Create a new message instance.
     *
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->order = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orders.adminOrderPaid')
            ->subject($this->order['subject'])
            ->with(['order' => $this->order]);
    }
}
