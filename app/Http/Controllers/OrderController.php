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

    public function dashboard()
    {
         session(['title' => 'Dashboard']);

        $labs = number_format(Lab::count());
        $libraries = number_format(Library::count());
        $stationaries = number_format(Stationary::count());
        $orders = Order::with('user')->latest()->get();

        return view('dashboard', compact('labs', 'libraries', 'stationaries', 'orders'));
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

        public function confirmPayOnDelivery(Request $request, $orderId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $order = Order::where('id', $orderId)->where('user_id', $user->id)->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Only allow status change if order is pending or pay_on_delivery
        if (!in_array($order->status, ['pending', 'pay_on_delivery'])) {
            return response()->json(['error' => 'Order payment cannot be confirmed'], 400);
        }

        $order->status = 'paid';
        $order->save();

        return response()->json([
            'message' => 'Payment confirmed successfully.',
            'order' => $order,
        ]);
    }
}
