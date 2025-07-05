<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Notifications\SMSNotification;
use Flutterwave\Rave;

class OrderController extends Controller
{
   public function checkout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        $order = Order::create([
            'user_id' => $user->id,
            'total' => $total,
            'status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Optionally clear cart
        Cart::where('user_id', $user->id)->delete();

        return response()->json(['order' => $order], 200);
    }

    public function initiatePayment(Request $request)
        {
            $user = Auth::user();
            $order = Order::where('user_id', $user->id)->latest()->first();

            $reference = 'EDU-' . uniqid();
            $order->payment_reference = $reference;
            $order->save();

            $paymentData = [
                'tx_ref' => $reference,
                'amount' => $order->total,
                'currency' => 'UGX',
                'payment_options' => 'mobilemoneyuganda',
                'redirect_url' => 'http://localhost:8080/payment-success',
                'customer' => [
                    'email' => $user->email,
                    'name' => $user->firstName,
                ],
                'customizations' => [
                    'title' => 'EduMall Order',
                    'description' => 'Payment for Order #' . $order->id
                ],
            ];

            return response()->json($paymentData);
        }


}
