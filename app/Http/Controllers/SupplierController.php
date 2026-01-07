<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user || $user->role_id !== 1) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage suppliers.'], 403);
        }

        return response()->json(Supplier::where('tenant_id', $user->tenant_id)->get());
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user || $user->role_id !== 1) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage suppliers.'], 403);
        }

        $request->validate([
            'name' => 'required|string|unique:suppliers,name,NULL,id,tenant_id,' . $user->tenant_id,
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        $supplier = Supplier::create([
            'tenant_id' => $user->tenant_id,
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return response()->json($supplier, 201);
    }

    public function show(Supplier $supplier)
    {
        $user = request()->user();
       if (!$user || $user->role_id !== 1) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage suppliers.'], 403);
        }

        return response()->json($supplier);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $user = $request->user();
        if (!$user || $user->role_id !== 1) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage suppliers.'], 403);
        }

        $request->validate([
            'name' => 'required|string|unique:suppliers,name,' . $supplier->id . ',id,tenant_id,' . $user->tenant_id,
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        $supplier->update($request->only(['name', 'contact', 'email', 'address']));
        return response()->json($supplier);
    }

    public function destroy(Supplier $supplier)
    {
        $user = request()->user();
        if (!$user || $user->role_id !== 1 || $supplier->tenant_id !== $user->tenant_id) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage suppliers.'], 403);
        }

        $supplier->delete();
        return response()->json(['message' => 'Supplier deleted']);
    }
}
