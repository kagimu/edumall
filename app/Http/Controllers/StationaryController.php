<?php

namespace App\Http\Controllers;

use App\Models\Stationary;
use Illuminate\Http\Request;

class StationaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stationaries = Stationary::all();
        return view('stationaries.index', compact('stationaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stationaries.create');
    }

    public function getStationaryByCategory($category)
    {
        $stationaries = Stationary::where('category', $category)->get();
        return view('stationaries.index', compact('stationaries'));
    }

    public function getStationary()
    {
        $stationaries = Stationary::all();
        return response()->json($stationaries);
    }

    public function getStationaryById($id)
    {
        $stationaries = Stationary::findOrFail($id);
        return response()->json($stationaries);
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
            'desc' => 'nullable|string',
        ]);

        Stationary::create($request->all());

        return redirect()->route('stationaries.index')->with('success', 'Stationary created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stationary $stationary)
    {
        return view('stationaries.show', compact('stationary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stationary $stationary)
    {
        return view('stationaries.edit', compact('stationary'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stationary $stationary)
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
            'desc' => 'nullable|string',
        ]);

        $stationary->update($request->all());

        return redirect()->route('stationaries.index')->with('success', 'Stationary updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stationary $stationary)
    {
        $stationary->delete();

        return redirect()->route('stationaries.index')->with('success', 'Stationary deleted successfully.');
    }
}
