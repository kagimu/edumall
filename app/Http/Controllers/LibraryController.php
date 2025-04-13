<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $libraries = Library::all();
        return view('libraries.index', compact('libraries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('libraries.create');
    }

    public function getLibrary()
    {
        $libraries = Library::all();
        return response()->json($libraries);
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
            'brand' => 'nullable|string',
            'in_stock' => 'nullable|integer',
            'condition' => 'required|in:new,old',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'desc' => 'nullable|string',
        ]);

        $library = new Library();
        $library->name = $request->name;
        $library->category = $request->category;
        $library->color = $request->color;
        $library->brand = $request->brand;
        $library->in_stock = $request->in_stock;
        $library->condition = $request->condition;
        // Add other fields as necessary

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('images/libraries', 'public');
            $library->avatar = $avatarPath;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath[] = $image->store('images/libraries', 'public');
            }
            $library->images = json_encode($imagePath);
        }

        // Save the library to the database
        $library->save();

        return redirect()->route('libraries.index')->with('success', 'Library created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Library $library)
    {
        return view('libraries.show', compact('library'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Library $library)
    {
        return view('libraries.edit', compact('library'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Library $library)
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

        $library->name = $request->name;
        $library->category = $request->category;
        $library->color = $request->color;
        $library->brand = $request->brand;
        $library->in_stock = $request->in_stock;
        $library->condition = $request->condition;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('images/libraries', 'public');
            $library->avatar = $avatarPath;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath[] = $image->store('images/libraries', 'public');
            }
            $library->images = json_encode($imagePath);
        }

        // Save the library to the database
        $library->save();

        return redirect()->route('libraries.index')->with('success', 'Library updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Library $library)
    {
        // Delete the image files
        if ($library->avatar) {
            \Storage::delete('public/' . $library->avatar);
        }

        if ($library->images) {
            foreach (json_decode($library->images) as $image) {
                \Storage::delete('public/' . $image);
            }
        }

        // Delete the library from the database
        $library->delete();

        return redirect()->route('libraries.index')->with('success', 'Library deleted successfully.');
    }
}
