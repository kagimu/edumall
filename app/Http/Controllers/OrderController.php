<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Services\SmsService;


class OrderController extends Controller
{
    public function index(Request $request)
    {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'message' => 'Unauthorized access.'
                ], 401);
            }

            $orders = Order::with('items.product')
                ->where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->get();


            return response()->json([
                'orders' => $orders,
                'status' => 200,
                'message' => 'Orders retrieved successfully'
            ]);
    }

    public function getAllOrders()
        {
            $orders = Order::with('items.product')
                ->orderByDesc('created_at')
                ->paginate(10);

            return view('orders.index', compact('orders'));
        }

   public function store(Request $request)
        {
            $user = auth()->user();

            if (!$user) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            // Validate incoming request
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
                'distance_km' => 'required|numeric',
                'delivery_fee' => 'required|numeric',
                'total' => 'required|numeric',
                'payment_method' => 'required|string',
                'payment_status' => 'required|in:pending,paid',
            ]);

            // Create order
            $order = new Order();
            $order->user_id = $user->id;
            $order->customer_name = $validated['customer_name'];
            $order->customer_email = $validated['customer_email'];
            // Ensure phone is in international format for sandbox
            $order->customer_phone = preg_replace('/^0/', '+256', $validated['customer_phone']);
            $order->delivery_info = json_encode($validated['address']);
            $order->subtotal = $validated['subtotal'];
            $order->distance_km = $validated['distance_km'];
            $order->delivery_fee = $validated['delivery_fee'];
            $order->total = $validated['total'];
            $order->payment_method = $validated['payment_method'];
            $order->payment_status = $validated['payment_status'];
            $order->save();

            // Save order items
            foreach ($validated['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Send confirmation email
            try {
                Mail::to($order->customer_email)->send(new \App\Mail\OrderConfirmation($order));
            } catch (\Exception $e) {
                \Log::error('Mail failed for order #' . $order->id . ': ' . $e->getMessage());
            }

            // Initialize SMS service
            $smsService = new \App\Services\SmsService();

            // Customer SMS
            $customerMessage = "Hello {$order->customer_name}, your order #{$order->id} has been received and is being processed. [Sandbox Test]";
            try {
                $result = $smsService->sendSms($order->customer_phone, $customerMessage);
                \Log::info('Customer SMS response:', ['response' => $result]);
            } catch (\Exception $e) {
                \Log::error('Customer SMS failed: ' . $e->getMessage());
            }

            // Admin SMS (sandbox requires verified number)
            $adminNumber = '+256762833491';
            $adminMessage = "New order #{$order->id} received from {$order->customer_name}. Total: UGX {$order->total}";
            try {
                $result = $smsService->sendSms($adminNumber, $adminMessage);
                \Log::info('Admin SMS response:', ['response' => $result]);
            } catch (\Exception $e) {
                \Log::error('Admin SMS failed: ' . $e->getMessage());
            }

            return response()->json([
                'message' => 'Order placed successfully. SMS sent (sandbox, check logs for response).',
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
