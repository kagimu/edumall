<?php

namespace App\Http\Controllers;

use App\Models\ComputerLab;
use Illuminate\Http\Request;

class ComputerLabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $computerLabs = ComputerLab::all();
        return view('computerlabs.index', compact('computerLabs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('computerlabs.create');
    }

    public function getComputerLab()
    {
        $computerLabs = ComputerLab::all();
        return response()->json($computerLabs);
    }


    public function getComputerLabByCategory($category)
    {
        $computerLabs = ComputerLab::where('category', $category)->get();
        return response()->json($computerLabs);
    }

    public function getComputerLabById($id)
    {
        $computerLab = ComputerLab::findOrFail($id);
        return response()->json($computerLab);
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

        ComputerLab::create($request->all());

        return redirect()->route('computerlabs.index')->with('success', 'Computer Lab created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ComputerLab $computerLab)
    {
        return view('computerlabs.show', compact('computerLab'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComputerLab $computerLab)
    {
        return view('computerlabs.edit', compact('computerLab'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComputerLab $computerLab)
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

        $computerLab->update($request->all());

        return redirect()->route('computerlabs.index')->with('success', 'Computer Lab updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComputerLab $computerLab)
    {
        $computerLab->delete();

        return redirect()->route('computerlabs.index')->with('success', 'Computer Lab deleted successfully.');
    }
}
