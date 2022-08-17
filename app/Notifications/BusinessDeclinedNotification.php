<?php

namespace App\Notifications;

use App\Models\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BusinessDeclinedNotification extends Notification
{
    use Queueable;
    /**
     * @var Business
     */
    public Business $business;

    /**
     * @var Comment
     */
    public $comment;

    /**
     * Create a new notification instance.
     *
     * @param Business $business
     */
    public function __construct(Business $business, $comment)
    {
        $this->business = $business;
        $this->comment = $comment;
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
        $url = route('merchant.business.show', $this->business);
        return (new MailMessage())
            // ->line('The introduction to the notification.')
            // ->action('Notification Action', url('/'))
            // ->line('APPLICATION COMMENT')
            // ->line($this->comment)
            // ->line('Thank you for using our application!');
            ->view('emails.businessDecline',['comment' => $this->comment,'url'=> $url]);
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
