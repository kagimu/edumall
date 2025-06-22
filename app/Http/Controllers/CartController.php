<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lab;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:labs,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        $product = Lab::findOrFail($request->product_id);

        // Add or update cart item
        $cart[$product->id] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => ($cart[$product->id]['quantity'] ?? 0) + $request->quantity,
            'avatar' => $product->avatar,
        ];

        session()->put('cart', $cart);

        return response()->json(['message' => 'Product added to cart', 'cart' => $cart], 200);
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:labs,id']);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return response()->json(['message' => 'Product removed from cart', 'cart' => $cart], 200);
    }

    public function view()
    {
        $cart = session()->get('cart', []);
        return response()->json(['cart' => $cart], 200);
    }
}
