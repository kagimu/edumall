<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\WhatsAppService;


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

    public function store(Request $request)
    {
        $user = auth()->user();

        $pendingOrder = Order::where('user_id', $user->id)
            ->where('payment_status', 'pending')
            ->first();

        if ($pendingOrder) {
            return response()->json([
                'message' => 'You have a pending order. Please complete payment before making a new one.',
            ], 403);
        }

        $validated = $request->validate([
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
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

        $order = new Order();
        $order->user_id = $user->id;
        $order->customer_name = $validated['customer_name'];
        $order->customer_email = $validated['customer_email'];
        $order->customer_phone = $validated['customer_phone'];
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

        // Format order details for WhatsApp
            $delivery = json_decode($order->delivery_info, true);
            $location = $delivery['address'] ?? 'N/A';
            $coords = $delivery['coordinates'] ?? ['lat' => 'N/A', 'lng' => 'N/A'];

            $message = "🛒 *NEW ORDER RECEIVED*\n"
                . "*Name:* {$order->customer_name}\n"
                . "*Phone:* {$order->customer_phone}\n"
                . "*Email:* {$order->customer_email}\n"
                . "*Location:* $location\n"
                . "*Coords:* {$coords['lat']}, {$coords['lng']}\n"
                . "*Total:* UGX " . number_format($order->total) . "\n"
                . "*Order ID:* #{$order->id}\n\n"
                . "*Items:*\n";

            // Append item details
            foreach ($order->items as $item) {
                $product = $item->product; // assuming relationship exists
                $message .= "- {$product->name} (x{$item->quantity}) - UGX " . number_format($item->price) . "\n";
            }

            // Send to multiple WhatsApp numbers
            $numbers = explode(',', env('ADMIN_WHATSAPP_NUMBERS')); // comma-separated list in .env

            foreach ($numbers as $number) {
                (new \App\Services\WhatsAppService())->sendMessage(trim($number), $message);
            }



        return response()->json([
            'message' => 'Order placed successfully',
            'order_id' => $order->id,
        ], 201);
    }

    public function checkPendingOrder(Request $request)
    {
        $user = $request->user();

        $pendingOrder = Order::where('user_id', $user->id)
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

    public function confirmPayOnDelivery(Request $request)
    {
        $user = auth()->user();

        $order = Order::where('user_id', $user->id)
            ->where('payment_status', 'pending')
            ->latest()
            ->first();

        if (!$order) {
            return response()->json(['error' => 'No pending order found.'], 404);
        }

        $order->update(['payment_status' => 'paid']);

        return response()->json([
            'message' => 'Payment confirmed successfully.',
            'order' => $order,
        ]);
    }
}
