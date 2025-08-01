<?php

namespace App\Notifications;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class SMSNotification
{
    protected $client;

    public function __construct()
    {
        // Using getenv() as Twilio recommends
        $sid = getenv('TWILIO_SID');
        $token = getenv('TWILIO_AUTH_TOKEN');

        // Assign to class property, not local variable
        $this->client = new Client($sid, $token);
    }

    public function sendOrderMessage(Order $order)
    {
        $delivery = json_decode($order->delivery_info, true);

        if (!$delivery) {
            Log::error("Order #{$order->id} has no valid delivery info.");
            return;
        }

        $body = "🛒 New Order Received! Order ID: #{$order->id} \n";
        $to = '+256762833491'; // Hardcoded recipient

        try {
            $message = $this->client->messages->create(
                $to,
                [
                    "messagingServiceSid" => "MG42ce7c4f1ef2a0d28e1cc7f5d6e358c6",
                    'body' => $body,
                ]
            );
            Log::info("Twilio SMS sent to $to. SID: " . $message->sid);
        } catch (\Exception $e) {
            Log::error("Failed to send SMS to $to: " . $e->getMessage());
        }
    }
}
