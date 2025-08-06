@extends('layouts.master')

@section('content')

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">ALL ORDERS MADE</h4>
    </div>

</div>
<!--End Page header-->

<!-- Row -->
<div class="col-xl-12 col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Orders</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Delivery Address</th>
                            <th>Payment</th>
                            <th>Total (UGX)</th>
                            <th>Status</th>
                            <th>Items</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            @php
                                $delivery = json_decode($order->delivery_info, true);
                            @endphp
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->customer_phone }}</td>
                                <td>{{ $order->customer_email }}</td>
                                <td>
                                    {{ $delivery['address'] ?? '' }},
                                    {{ $delivery['city'] ?? '' }},
                                    {{ $delivery['district'] ?? '' }}
                                </td>
                                <td>{{ $order->payment_method }} ({{ $order->payment_status }})</td>
                                <td>{{ number_format($order->total) }}</td>
                                <td>
                                    @if($order->payment_status === 'paid')
                                        <span class="badge badge-success">Paid</span>
                                    @else
                                        <span class="badge badge-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <ul style="padding-left: 16px;">
                                        @foreach($order->items as $item)
                                            <li>{{ $item->product->name ?? 'Item Name' }} --> {{ $item->quantity }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach

                        @if($orders->isEmpty())
                            <tr>
                                <td colspan="10" class="text-center text-muted">No orders found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </div>
</div>

    <!-- End Row -->
    <!--End Page header-->

    @endsection
