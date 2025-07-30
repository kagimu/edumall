<x-mail::message>
@php
    $delivery = json_decode($order->delivery_info, true);
@endphp

<img src="https://i.imgur.com/pVSiE9j.png" alt="{{ config('app.name') }}" width="120" style="margin-bottom: 20px;">

# Order Confirmation

Dear {{ $order->customer_name }},

Thank you for your order. We’ve received it and it's being processed.

---

**Order ID**: #{{ $order->id }}
**Total**: UGX {{ number_format($order->total) }}

---

## Delivery Information

**Name**: {{ $order->customer_name }}
**Phone**: {{ $delivery['phone'] ?? 'N/A' }}
**Email**: {{ $delivery['email'] ?? 'N/A' }}
**Address**: {{ $delivery['address'] ?? 'N/A' }}
**Delivery Method**: {{ $delivery['method'] ?? 'Standard Delivery' }}

<x-mail::panel>
We’ll notify you once your items are out for delivery.
</x-mail::panel>

Thanks for shopping with us!

---

**{{ config('app.name') }}**
📞 0781 978910, 0772 113800
📍 Kampala, Uganda
🌐 [edumallug.com](https://edumallug.com)

</x-mail::message>
