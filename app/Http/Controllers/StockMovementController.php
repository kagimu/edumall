<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index() {
        return StockMovement::with(['item', 'user'])->orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request) {
        $user = $request->user();
        if (!$user || $user->role_id !== 1) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage stock movements.'], 403);
        }

        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:purchase,use,return,disposal',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:500'
        ]);

        $item = Item::findOrFail($data['item_id']);

        // Calculate quantity change based on type
        $quantityChange = 0;
        switch ($data['type']) {
            case 'purchase':
                $quantityChange = $data['quantity'];
                break;
            case 'use':
            case 'disposal':
                $quantityChange = -$data['quantity'];
                break;
            case 'return':
                $quantityChange = $data['quantity'];
                break;
        }

        // Check if we have enough stock for outgoing movements
        if ($quantityChange < 0 && $item->quantity < abs($quantityChange)) {
            return response()->json(['error' => 'Insufficient stock for this operation'], 400);
        }

        // Create stock movement
        $movement = StockMovement::create([
            'user_id' => auth()->id(),
            'item_id' => $data['item_id'],
            'type' => $data['type'],
            'quantity' => $data['quantity'],
            'note' => $data['note'] ?? null,
        ]);

        // Update item quantity
        $item->quantity += $quantityChange;
        $item->save();

        return $movement->load(['item', 'user']);
    }

    public function show(StockMovement $stockMovement) {
        return $stockMovement->load(['item', 'user']);
    }

    public function update(Request $request, StockMovement $stockMovement) {
        $user = $request->user();
        if (!$user || $user->role_id !== 1) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage stock movements.'], 403);
        }

        // Note: Stock movements should typically not be editable after creation
        // This is for admin corrections only
        $data = $request->validate([
            'note' => 'nullable|string|max:500'
        ]);

        $stockMovement->update($data);
        return $stockMovement->load(['item', 'user']);
    }

    public function destroy(StockMovement $stockMovement) {
        $user = request()->user();
        if (!$user || $user->role_id !== 1) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage stock movements.'], 403);
        }

        // Reversing the stock movement
        $item = $stockMovement->item;
        $quantityChange = 0;

        switch ($stockMovement->type) {
            case 'purchase':
                $quantityChange = -$stockMovement->quantity;
                break;
            case 'use':
            case 'disposal':
                $quantityChange = $stockMovement->quantity;
                break;
            case 'return':
                $quantityChange = -$stockMovement->quantity;
                break;
        }

        $item->quantity += $quantityChange;
        $item->save();

        $stockMovement->delete();
        return response()->json(['message' => 'Stock movement deleted and inventory adjusted']);
    }
}
