<?php

namespace App\Broadcasting;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (! $notifiable->phone_number) {
            return; // Skip if no phone number
        }

        $message = $notification->toSms($notifiable);

        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        $twilio->messages->create(
            $notifiable->phone_number,
            [
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => $message,
            ]
        );
    }
}
