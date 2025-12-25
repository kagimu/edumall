<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockMovementController extends Controller
{
        public function store(Request $request) {
        $data = $request->validate([
            'item_id'=>'required', 'type'=>'required',
            'quantity'=>'required|integer'
        ]);

        $movement = StockMovement::create([
            'user_id'=>auth()->id(), 
            ...$data
        ]);

        // Update item quantity logic
        $item = Item::find($data['item_id']);
        $this->authorize('stockOut', $item);
        $item->quantity += $data['type'] === 'in' ? $data['quantity'] : -$data['quantity'];
        $item->save();

        return $movement;
    }
}
