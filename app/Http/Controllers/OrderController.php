<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Notifications\SMSNotification;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $total = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        $order = Order::create([
            'user_id' => auth()->id(), // For authenticated users
            'cart' => json_encode($cart),
            'total' => $total,
        ]);

        // Clear the session cart
        session()->forget('cart');

        // Get the authenticated user
        $user = auth()->user();

        // Send SMS notification
        if ($user && $user->phone_number) { // Ensure the user has a phone number
            $user->notify(new SMSNotification("Your order #{$order->id} has been placed successfully! Total: $total."));
        }

        return response()->json(['message' => 'Order placed successfully', 'order' => $order], 201);
    }
}
