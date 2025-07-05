<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Lab;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $total = $cartItems->sum(fn ($item) => $item->quantity * $item->product->price);

        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total' => $total,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        return response()->json([
            'success' => true,
            'order' => $order,
        ]);
    }

    public function pay(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $order = Order::where('user_id', $user->id)->where('status', 'pending')->latest()->first();

        if (!$order) {
            return response()->json(['message' => 'No pending order found'], 404);
        }

        $tx_ref = 'EDUMALL-' . uniqid();

        $payload = [
            'tx_ref' => $tx_ref,
            'amount' => $order->total,
            'currency' => 'UGX',
            'redirect_url' => 'http://localhost:8080/payment-success',
            'customer' => [
                'email' => $user->email,
                'name' => $user->firstName . ' ' . $user->lastName,
            ],
            'customizations' => [
                'title' => 'Edumall Checkout',
                'description' => 'Order #' . $order->id,
            ],
        ];

        $response = Http::withToken(env('FLUTTERWAVE_SECRET_KEY'))
            ->post('https://api.flutterwave.com/v3/payments', $payload);

        if ($response->failed()) {
            return response()->json(['message' => 'Payment initiation failed'], 500);
        }

        return response()->json([
            'payment_link' => $response['data']['link'],
        ]);
    }

   
}
