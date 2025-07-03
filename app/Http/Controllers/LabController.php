<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session(['title' => 'Laboratory Items']);
        $labs = Lab::all();
        return view('labs.index', compact('labs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('labs.create');
    }

    public function getLab()
    {
        $labs = Lab::all();

        if ($labs->isEmpty()) {
            return response()->json([
                'message' => 'No labs found.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'message' => 'Labs retrieved successfully.',
            'data' => $labs
        ], 200);
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|in:apparatus,specimen,chemical',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Max 10MB
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240', // Max 10MB for each image
            'color' => 'nullable|string',
            'rating' => 'nullable|string',
            'in_stock' => 'nullable|string',
            'condition' => 'required|in:new,old',
            'price' => 'required|string',
            'unit' => 'nullable|string',
            'desc' => 'nullable|string',
        ]);

        $lab = new Lab();
        $lab->name = $request->name;
        $lab->category = $request->category;
        $lab->purchaseType = $request->purchaseType;
        $lab->category = $request->category;
        $lab->color = $request->color;
        $lab->rating = $request->rating;
        $lab->in_stock = $request->in_stock;
        $lab->condition = $request->condition;
        $lab->price = $request->price;
        $lab->unit = $request->unit;
        $lab->desc = $request->desc;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('images/labs', 'public');
            $lab->avatar = $avatarPath;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath[] = $image->store('images/labs', 'public');
            }
            $lab->images = json_encode($imagePath);
        }

        $lab->save();

        return redirect()->route('index.labs')->with('success', 'Lab created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lab $lab)
    {
        return view('labs.show', compact('lab'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lab $lab)
    {
        return view('labs.edit', compact('lab'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lab $lab)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|in:apparatus,specimen,chemical',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Max 10MB
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240', // Max 10MB for each image
            'color' => 'nullable|string',
            'brand' => 'nullable|string',
            'in_stock' => 'nullable|integer',
            'condition' => 'required|in:new,old',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'desc' => 'nullable|string',
        ]);

        $lab->name = $request->name;
        $lab->category = $request->category;
        $lab->color = $request->color;
        $lab->brand = $request->brand;
        $lab->in_stock = $request->in_stock;
        $lab->condition = $request->condition;
        $lab->price = $request->price;
        $lab->discount = $request->discount;
        $lab->desc = $request->desc;

        if ($request->hasFile('avatar')) {
            if ($lab->avatar) {
                \Storage::delete('public/' . $lab->avatar);
            }
            $avatarPath = $request->file('avatar')->store('images/labs', 'public');
            $lab->avatar = $avatarPath;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if (isset($lab->images)) {
                    \Storage::delete('public/' . json_decode($lab->images));
                }
                $imagePath[] = $image->store('images/labs', 'public');
            }
            $lab->images = json_encode($imagePath);
        }

        $lab->save();

        return redirect()->route('labs.index')->with('success', 'Lab updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lab $lab)
    {
        // Delete the avatar image
        if ($lab->avatar) {
            \Storage::delete('public/' . $lab->avatar);
        }

        // Delete the images
        if (isset($lab->images)) {
            foreach (json_decode($lab->images) as $image) {
                \Storage::delete('public/' . $image);
            }
        }

        $lab->delete();

        return redirect()->route('labs.index')->with('success', 'Lab deleted successfully.');
    }
}
