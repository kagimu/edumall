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
        session(['title' => 'Computer computerLabs']);
        $computerlabs = ComputerLab::all();
        return view('computerlabs.index', compact('computerlabs'));
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
        $computerlabs = ComputerLab::all();
        return response()->json($computerlabs);
    }


    public function getComputerLabByCategory($category)
    {
        $computerlabs = ComputerLab::where('category', $category)->get();
        return response()->json($computerlabs);
    }

    public function getComputerLabById($id)
    {
        $ComputerLab = ComputerLab::findOrFail($id);
        return response()->json($ComputerLab);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'avatar' => 'nulcomputerLable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nulcomputerLable|array',
            'color' => 'nulcomputerLable|string|max:255',
            'brand' => 'nulcomputerLable|string|max:255',
            'in_stock' => 'nulcomputerLable|integer',
            'condition' => 'required|in:new,old',
            'price' => 'required|numeric',
            'discount' => 'nulcomputerLable|numeric',
            'desc' => 'nulcomputerLable|string|max:1000',
        ]);

        $computerLab = new ComputerLab();
        $computerLab->name = $request->name;
        $computerLab->category = $request->category;
        $computerLab->color = $request->color;
        $computerLab->brand = $request->brand;
        $computerLab->in_stock = $request->in_stock;
        $computerLab->condition = $request->condition;
        $computerLab->price = $request->price;
        $computerLab->discount = $request->discount;
        $computerLab->desc = $request->desc;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('images/computerLabs', 'public');
            $computerLab->avatar = $avatarPath;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath[] = $image->store('images/computerLabs', 'public');
            }
            $computerLab->images = json_encode($imagePath);
        }

        $computerLab->save();

        return redirect()->route('index.computerlabs')->with('success', 'Computer computerLab created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ComputerLab $ComputerLab)
    {
        return view('computerlabs.show', compact('ComputerLab'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComputerLab $ComputerLab)
    {
        return view('computerlabs.edit', compact('ComputerLab'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComputerLab $ComputerLab)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'avatar' => 'nulcomputerLable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nulcomputerLable|array',
            'color' => 'nulcomputerLable|string|max:255',
            'brand' => 'nulcomputerLable|string|max:255',
            'in_stock' => 'nulcomputerLable|integer',
            'condition' => 'required|in:new,old',
            'price' => 'required|string',
            'discount' => 'nulcomputerLable|string',
            'desc' => 'nulcomputerLable|string|max:1000',
        ]);

        $ComputerLab->update($request->all());

        return redirect()->route('computerlabs.index')->with('success', 'Computer computerLab updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComputerLab $ComputerLab)
    {
         // Delete the avatar image
         if ($ComputerLab->avatar) {
            \Storage::delete('public/' . $ComputerLab->avatar);
        }

        // Delete the images
        if (isset($ComputerLab->images)) {
            foreach (json_decode($ComputerLab->images) as $image) {
                \Storage::delete('public/' . $image);
            }
        }
        $ComputerLab->delete();

        return redirect()->route('computerlabs.index')->with('success', 'Computer computerLab deleted successfully.');
    }
}
