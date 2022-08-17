<?php

namespace App\Notifications;

use App\Models\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class BusinessReviewRequest extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Business
     */
    public Business $business;

    /**
     * Create a new notification instance.
     *
     * @param Business $business
     */
    public function __construct(Business $business)
    {
        $this->business = $business;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(Lang::get('Merchant Review Request'))
            ->greeting("Hello {$notifiable->first_name},")
            ->line("A merchant just requested for a review of their business ({$this->business->name}) .")
            ->action('View Merchant Profile', url(route('admin.business.show', $this->business)))
            ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}
