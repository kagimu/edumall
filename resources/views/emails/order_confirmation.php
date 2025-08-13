@component('mail::message')
# Order Confirmation

Hello **{{ $order->customer_name }}**,

Thank you for your order with **Edumall Uganda**!
We have received your order and it is now being processed.

---

**Order ID:** #{{ $order->id }}
**Order Date:** {{ $order->created_at->format('F j, Y') }}
**Total Amount:** UGX {{ number_format($order->total_amount, 2) }}

---

## Order Details:
@component('mail::table')
| Item         | Quantity | Price (UGX) |
|--------------|----------|-------------|
@foreach ($order->items as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | {{ number_format($item->price, 2) }} |
@endforeach
@endcomponent

---

@component('mail::button', ['url' => url('/orders/'.$order->id)])
View Your Order
@endcomponent

If you have any questions about your order, simply reply to this email or contact our support team.

Thanks again for shopping with us!
**The Edumall Uganda Team**

@endcomponent
