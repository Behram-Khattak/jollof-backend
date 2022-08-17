<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class TwilioWhatsApp
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toWhatsApp($notifiable);

        $to = $notifiable->routeNotificationFor('WhatsApp');

        $from = config('services.twilio.whatsapp_number');

        try {
            $twilio = new Client(config('services.twilio.account_sid'), config('services.twilio.auth_token'));
        } catch (ConfigurationException $e) {
            \Log::error($e);
        }

        return $twilio->messages->create("whatsapp:{$to}", [
            'from' => "whatsapp:{$from}",
            'body' => $message->content,
        ]);
    }
}
