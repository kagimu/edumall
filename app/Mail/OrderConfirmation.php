<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation - #' . $this->order->id,
            from: 'sales@edumallug.com',
            replyTo: ['kagimujayp01@gmail.com']
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order_confirmation',
            with: [
                'order' => $this->order,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
