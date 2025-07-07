<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Notifications\SMSNotification;
use Flutterwave\Rave;

class OrderController extends Controller
{
    public function index(Request $request)
        {
            $user = $request->user();

            $orders = Order::with('items')
                ->where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->get();

            return response()->json([
                'orders' => $orders
            ]);
        }

        /**
         * Store a new order
         */


    public function store(Request $request)
        {
            $user = auth()->user();

            // Check for existing pending order
            $pendingOrder = \App\Models\Order::where('user_id', $user->id)
                ->where('payment_status', 'pending')
                ->first();

            if ($pendingOrder) {
                return response()->json([
                    'message' => 'You have a pending order. Please complete payment before making a new one.',
                ], 403);
            }

            $validated = $request->validate([
                'customer' => 'required|array',
                'customer.name' => 'required|string',
                'customer.email' => 'required|email',
                'customer.phone' => 'required|string',
                'address' => 'required|array',
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|integer',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric',
                'subtotal' => 'required|numeric',
                'delivery_fee' => 'required|numeric',
                'total' => 'required|numeric',
                'payment_method' => 'required|string',
                'payment_status' => 'required|in:pending,paid',
            ]);

            $order = new \App\Models\Order();
            $order->user_id = $user->id;
            $order->customer_name = $validated['customer']['name'];
            $order->customer_email = $validated['customer']['email'];
            $order->customer_phone = $validated['customer']['phone'];
            $order->delivery_info = json_encode($validated['address']);
            $order->subtotal = $validated['subtotal'];
            $order->delivery_fee = $validated['delivery_fee'];
            $order->total = $validated['total'];
            $order->payment_method = $validated['payment_method'];
            $order->payment_status = $validated['payment_status'];
            $order->save();

            foreach ($validated['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            return response()->json([
                'message' => 'Order placed successfully',
                'order_id' => $order->id,
            ], 201);
        }

        public function checkPendingOrder(Request $request)
            {
                $user = $request->user();

                $pendingOrder = \App\Models\Order::where('user_id', $user->id)
                    ->where('payment_status', 'pending')
                    ->latest()
                    ->first();

                if ($pendingOrder) {
                    return response()->json([
                        'pending' => true,
                        'order_id' => $pendingOrder->id,
                    ]);
                }

                return response()->json(['pending' => false]);
            }


        public function confirmPayOnDelivery(Request $request, $orderId)
            {
                $user = auth()->user();

                $order = Order::where('id', $orderId)->where('user_id', $user->id)->first();

                if (!$order || $order->payment_status !== 'pending') {
                    return response()->json(['error' => 'Invalid or already paid order.'], 400);
                }

                $order->update(['payment_status' => 'paid']);

                return response()->json([
                    'message' => 'Payment status updated successfully.',
                    'order' => $order,
                ]);
            }


}
