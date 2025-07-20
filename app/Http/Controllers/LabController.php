<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LabController extends Controller
{
    public function index()
    {
        session(['title' => 'Laboratory Items']);
        $labs = Lab::all();
        return view('labs.index', compact('labs'));
    }

    public function create()
    {
        return view('labs.create');
    }

    public function getLab()
    {
        $labs = Lab::all();

        return response()->json([
            'message' => 'Labs retrieved successfully.',
            'data' => $labs
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'category' => 'required|in:apparatus,specimen,chemical',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'color' => 'nullable|string',
            'rating' => 'nullable|string',
            'in_stock' => 'nullable|string',
            'condition' => 'required|in:new,old',
            'price' => 'required|string',
            'unit' => 'nullable|string',
            'desc' => 'nullable|string',
            'purchaseType' => 'nullable|string',
        ]);

        $lab = new Lab($validated);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $lab->avatar = $request->file('avatar')->store('images/labs', 'public');
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            $images = collect($request->file('images'))->map(function ($image) {
                return $image->store('images/labs', 'public');
            });
            $lab->images = $images->toArray();
        }

        $lab->save();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Lab created successfully.',
                'data' => $lab
            ], 201);
        }

        return redirect()->route('labs.index')->with('status', 'Lab created successfully.');
    }

    public function show(Lab $lab)
    {
        return view('labs.show', compact('lab'));
    }

    public function edit(Lab $lab)
    {
        return view('labs.edit', compact('lab'));
    }

    public function update(Request $request, Lab $lab)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'category' => 'required|in:apparatus,specimen,chemical',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'color' => 'nullable|string',
            'rating' => 'nullable|string',
            'in_stock' => 'nullable|string',
            'condition' => 'required|in:new,old',
            'price' => 'required|string',
            'unit' => 'nullable|string',
            'desc' => 'nullable|string',
            'purchaseType' => 'nullable|string',
        ]);

        $lab->fill($validated);

        // Handle avatar update
        if ($request->hasFile('avatar')) {
            if ($lab->avatar) {
                Storage::disk('public')->delete($lab->avatar);
            }
            $lab->avatar = $request->file('avatar')->store('images/labs', 'public');
        }

        // Handle images update
        if ($request->hasFile('images')) {
            if (!empty($lab->images)) {
                foreach ($lab->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $images = collect($request->file('images'))->map(function ($image) {
                return $image->store('images/labs', 'public');
            });

            $lab->images = $images->toArray();
        }

        $lab->save();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Lab updated successfully.',
                'data' => $lab
            ], 200);
        }

        return redirect()->route('labs.index')->with('status', 'Lab updated successfully.');
    }

    public function destroy(Lab $lab)
    {
        if ($lab->avatar) {
            Storage::disk('public')->delete($lab->avatar);
        }

        if (!empty($lab->images)) {
            foreach ($lab->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $lab->delete();

        return redirect()->route('labs.index')->with('success', 'Lab deleted successfully.');
    }
}
