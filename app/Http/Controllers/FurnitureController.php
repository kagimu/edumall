<?php

namespace App\Http\Controllers;

use App\Models\Furniture;
use Illuminate\Http\Request;

class FurnitureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $furnitures = Furniture::all();
        return view('furnitures.index', compact('furnitures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('furnitures.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array',
            'color' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'in_stock' => 'nullable|integer',
            'condition' => 'required|in:new,old',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'desc' => 'nullable|string|max:1000',
        ]);

        Furniture::create($request->all());

        return redirect()->route('furnitures.index')->with('success', 'Furniture created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Furniture $furniture)
    {
        return view('furnitures.show', compact('furniture'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Furniture $furniture)
    {
        return view('furnitures.edit', compact('furniture'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Furniture $furniture)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array',
            'color' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'in_stock' => 'nullable|integer',
            'condition' => 'required|in:new,old',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'desc' => 'nullable|string|max:1000',
        ]);

        $furniture->update($request->all());

        return redirect()->route('furnitures.index')->with('success', 'Furniture updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Furniture $furniture)
    {
        $furniture->delete();

        return redirect()->route('furnitures.index')->with('success', 'Furniture deleted successfully.');
    }
}
