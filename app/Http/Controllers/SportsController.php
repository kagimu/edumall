<?php

namespace App\Http\Controllers;

use App\Models\Sports;
use Illuminate\Http\Request;

class SportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sports = Sports::all();
        return view('sports.index', compact('sports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sports.create');
    }

    public function getSports()
    {
        $sports = Sports::all();
        return response()->json($sports);
    }

    public function getSportsByCategory($category)
    {
        $sports = Sports::where('category', $category)->get();
        return response()->json($sports);
    }

    public function getSportsById($id)
    {
        $sports = Sports::find($id);
        return response()->json($sports);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:balls,jerseys,board_games,indoor_games',
            'avatar' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'color' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'in_stock' => 'nullable|integer|min:0',
            'condition' => 'required|in:new,old',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:' . $request->price,
            'desc' => 'nullable|string|max:1000',
        ]);

        $sports = Sports::create($request->all());

        return redirect()->route('sports.index')->with('success', 'Sports created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sports $sports)
    {
        return view('sports.show', compact('sports'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sports $sports)
    {
        return view('sports.edit', compact('sports'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sports $sports)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:balls,jerseys,board_games,indoor_games',
            'avatar' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'color' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'in_stock' => 'nullable|integer|min:0',
            'condition' => 'required|in:new,old',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:' . $request->price,
            'desc' => 'nullable|string|max:1000',
        ]);

        $sports->update($request->all());

        return redirect()->route('sports.index')->with('success', 'Sports updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sports $sports)
    {
        $sports->delete();

        return redirect()->route('sports.index')->with('success', 'Sports deleted successfully.');
    }
}
