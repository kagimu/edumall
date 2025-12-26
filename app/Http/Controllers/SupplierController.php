<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user->is_school_admin) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage suppliers.'], 403);
        }

        if (!$user->school_id) {
            return response()->json(['error' => 'User does not have an associated school'], 400);
        }

        $suppliers = Supplier::where('school_id', $user->school_id)->get();
        return response()->json($suppliers);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user->is_school_admin) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage suppliers.'], 403);
        }

        if (!$user->school_id) {
            return response()->json(['error' => 'User does not have an associated school'], 400);
        }

        $request->validate([
            'name' => 'required|string|unique:suppliers,name,NULL,id,school_id,' . $user->school_id,
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        $supplier = Supplier::create([
            'school_id' => $user->school_id,
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
        if (!$user->is_school_admin || $supplier->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage suppliers.'], 403);
        }

        return response()->json($supplier);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $user = $request->user();
        if (!$user->is_school_admin || $supplier->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage suppliers.'], 403);
        }

        $request->validate([
            'name' => 'required|string|unique:suppliers,name,' . $supplier->id . ',id,school_id,' . $user->school_id,
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
        if (!$user->is_school_admin || $supplier->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage suppliers.'], 403);
        }

        $supplier->delete();
        return response()->json(['message' => 'Supplier deleted']);
    }
}
