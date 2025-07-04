<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lab;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function allCarts()
        {
            $cartItems = Cart::with(['user', 'product']) // Eager load user and product (Lab) data
                ->orderBy('user_id') // Optional: group output by user
                ->get()
                ->map(function ($item) {
                    return [
                        'user_id' => $item->user->id,
                        'user_name' => $item->user->firstName,
                        'product_id' => $item->product->id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'avatar' => $item->product->avatar,
                        'quantity' => $item->quantity,
                        'total' => $item->quantity * $item->product->price,
                    ];
                });

            return response()->json(['carts' => $cartItems], 200);
        }

    public function add(Request $request)
    {
        $request->validate([
                    'product_id' => 'required|exists:labs,id',
                    'quantity' => 'required|integer|min:1',
                ]);

                $user = Auth::user();
                if (!$user) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }

                $product = Lab::findOrFail($request->product_id);

                $cartItem = Cart::where('user_id', $user->id)
                                ->where('product_id', $product->id)
                                ->first();

                if ($cartItem) {
                    $cartItem->quantity += $request->quantity;
                    $cartItem->save();
                } else {
                    Cart::create([
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                        'quantity' => $request->quantity,
                    ]);
                }

                return response()->json(['message' => 'Product added to cart'], 200);
    }

    public function remove(Request $request)

        {
            $request->validate(['product_id' => 'required|exists:labs,id']);

            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            Cart::where('user_id', $user->id)
                ->where('product_id', $request->product_id)
                ->delete();

            return response()->json(['message' => 'Product removed from cart'], 200);
        }


    public function view()
        {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Get all cart items for the user with the associated product
            $cartItems = Cart::with('product') // eager load Lab data
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc') // sort by newest first
                ->get()
                ->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'name' => $item->product->name ?? 'N/A',
                        'price' => $item->product->price ?? 0,
                        'avatar' => $item->product->avatar_url ?? null,
                        'quantity' => $item->quantity,
                    ];
                });

            return response()->json(['cart' => $cartItems], 200);
        }

}
