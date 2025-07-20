<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use Illuminate\Http\Request;

class LabApiController extends Controller
{
    public function index()
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

        return response()->json([
            'message' => 'Lab created successfully.',
            'data' => $lab
        ], 201);
    }
}
