<x-mail::message>
    @component('mail::message')
    # Order Confirmation
    
    Dear {{ $order->customer_name }},
    
    Thank you for your order. We have received your order and it's now being processed.
    
    **Order ID**: #{{ $order->id }}  
    **Total**: UGX {{ number_format($order->total) }}
    
    @component('mail::panel')
    We'll notify you once your items are out for delivery.
    @endcomponent
    
    Thanks,  
    {{ config('app.name') }}
    @endcomponent
    
</x-mail::message>
