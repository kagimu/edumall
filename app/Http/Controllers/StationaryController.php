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
        session(['title' => 'Stationaries']);
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
            'price' => 'required|string',
            'discount' => 'nullable|string',
            'desc' => 'nullable|string',
        ]);

        $stationaries = new Stationary();
        $stationaries->name = $request->name;
        $stationaries->category = $request->category;
        $stationaries->color = $request->color;
        $stationaries->brand = $request->brand;
        $stationaries->in_stock = $request->in_stock;
        $stationaries->condition = $request->condition;
        $stationaries->price = $request->price;
        $stationaries->discount = $request->discount;
        $stationaries->desc = $request->desc;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('images/labs', 'public');
            $stationaries->avatar = $avatarPath;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath[] = $image->store('images/labs', 'public');
            }
            $stationaries->images = json_encode($imagePath);
        }

        $stationaries ->save();

        return redirect()->route('index.stationaries')->with('success', 'Stationary created successfully.');
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
          // Delete the avatar image
          if ($stationary->avatar) {
            \Storage::delete('public/' . $stationary->avatar);
        }

        // Delete the images
        if (isset($stationary->images)) {
            foreach (json_decode($stationary->images) as $image) {
                \Storage::delete('public/' . $image);
            }
        }

        $stationary->delete();

        return redirect()->route('stationaries.index')->with('success', 'Stationary deleted successfully.');
    }
}
