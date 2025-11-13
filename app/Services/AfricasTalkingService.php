<?php

namespace App\Services;

use AfricasTalking\SDK\AfricasTalking;

class SmsService
{
    protected $sms;

    public function __construct()
    {
        $username = env('AFRICASTALKING_USERNAME');
        $apiKey = env('AFRICASTALKING_API_KEY');

        $AT = new AfricasTalking($username, $apiKey);
        $this->sms = $AT->sms();
    }

    public function sendSms($to, $message)
    {
        $from = env('AFRICASTALKING_SENDER_ID', 'EDUMALL-UG');

        try {
            $result = $this->sms->send([
                'to' => $to,
                'message' => $message,
                'from' => $from,
            ]);

            \Log::info('SMS sent successfully', ['response' => $result]);
            return $result;
        } catch (\Exception $e) {
            \Log::error('Failed to send SMS: ' . $e->getMessage());
        }
    }
}
