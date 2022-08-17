<?php

namespace App\Mail;

use App\Models\Business;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\MailTemplates\TemplateMailable;

class BusinessReviewMail extends TemplateMailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * @var Business
     */
    public Business $business;
    /**
     * @var User
     */
    public User $user;

    /**
     * Create a new message instance.
     *
     * @param Business $business
     * @param User     $user
     */
    public function __construct(Business $business, User $user)
    {
        $this->business = $business;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Merchant Review Request')
            ->view('emails.business.review');
    }
}
