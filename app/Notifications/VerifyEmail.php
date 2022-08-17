<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class VerifyEmail extends BaseVerifyEmail //implements ShouldQueue
{
    // use Queueable;

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }
        $name = $notifiable->first_name;

        return (new MailMessage())
            // ->subject(Lang::get('Verify Email Address'))
            // ->greeting("Hello {$notifiable->first_name}!")
            // ->line(Lang::get('Please click the button below to verify your email address.'))
            // ->action(Lang::get('Verify Email Address'), $verificationUrl)
            // ->line(Lang::get('If you did not create an account, no further action is required.'));
            ->view('emails.EmailVerification',['url' => $verificationUrl,'name' => $name]);
    }
}
