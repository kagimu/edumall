<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function index() {
        return Item::with(['category','supplier','location'])->get();
    }

   public function store(Request $request) {
    $user = $request->user();

    // ✅ Ensure user is an admin
    if ($user->role_id !== 1) {
        return response()->json(['error' => 'Unauthorized. Only admins can manage inventory.'], 403);
    }

    // ✅ Ensure user is linked to a school
    if (!$user->school_id) {
        return response()->json(['error' => 'User does not have an associated school'], 400);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'nullable|exists:categories,id',
        'supplier_id' => 'nullable|exists:suppliers,id',
        'location_id' => 'nullable|exists:locations,id',
        'quantity' => 'required|integer|min:0',
        'min_quantity' => 'required|integer|min:0',
        'expiry_date' => 'nullable|date',
    ]);

    // ✅ Link item to admin's school
    $validated['school_id'] = $user->school_id;

    return Item::create($validated);
}


    public function show(Item $item) {
        return $item->load(['category','supplier','location']);
    }

    public function update(Request $request, Item $item) {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'location_id' => 'nullable|exists:locations,id',
            'quantity' => 'sometimes|required|integer|min:0',
            'min_quantity' => 'sometimes|required|integer|min:0',
            'expiry_date' => 'nullable|date',
        ]);

        $item->update($validated);
        return $item->load(['category','supplier','location']);
    }

    public function destroy(Item $item) {
        $item->delete();
        return response()->json(['message' => 'Item deleted successfully']);
    }

    public function lowStock() {
        return Item::whereColumn('quantity','<=','min_quantity')->with(['category','supplier','location'])->get();
    }

    public function names() {
        return Item::where('school_id', session('tenant_school_id'))->pluck('name')->unique()->values();
    }
}
