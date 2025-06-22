<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class SMSNotification extends Notification
{
    use Queueable;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['sms'];
    }

    public function toSms($notifiable)
    {
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        $twilio->messages->create(
            $notifiable->phone_number, // Recipient's phone number
            [
                'from' => env('TWILIO_PHONE_NUMBER'), // Twilio number
                'body' => $this->message, // Message content
            ]
        );
    }
}
