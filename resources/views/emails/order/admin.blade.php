@component('mail::message')
# New Order Received

A new order has been placed:

**Customer**: {{ $order->customer_name }}  
**Phone**: {{ $order->customer_phone }}  
**Email**: {{ $order->customer_email }}  
**Total**: UGX {{ number_format($order->total) }}

**Location**:  
@php $delivery = json_decode($order->delivery_info, true); @endphp
{{ $delivery['address'] ?? 'Not provided' }}  
Lat: {{ $delivery['coordinates']['lat'] ?? 'N/A' }}  
Lng: {{ $delivery['coordinates']['lng'] ?? 'N/A' }}

@component('mail::button', ['url' => url('/admin/orders/'.$order->id)])
View Order
@endcomponent

@endcomponent
