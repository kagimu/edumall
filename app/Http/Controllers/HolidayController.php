<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session(['title' => 'Holidays']);
        $holidays = Holiday::all();
        return view('holidays.index', compact('holidays'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('holidays.create');
    }

    public function getHolidays()
    {
        $holidays = Holiday::all();
        return response()->json($holidays);
    }

    public function getHolidaysByCategory($category)
    {
        $holidays = Holiday::where('category', $category)->get();
        return response()->json($holidays);
    }

    public function getHolidaysById($id)
    {
        $holiday = Holiday::find($id);
        return response()->json($holiday);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:beach,mountain,city',
            'avatar' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'color' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'in_stock' => 'nullable|integer|min:0',
            'condition' => 'required|in:new,old',
            'price' => 'required|string|min:0',
            'discount' => 'nullable|string|min:0|max:100',
            'desc' => 'nullable|string|max:1000'
        ]);

        
        $holidays = new Holiday();
        $holidays->name = $request->name;
        $holidays->category = $request->category;
        $holidays->color = $request->color;
        $holidays->brand = $request->brand;
        $holidays->in_stock = $request->in_stock;
        $holidays->condition = $request->condition;
        $holidays->price = $request->price;
        $holidays->discount = $request->discount;
        $holidays->desc = $request->desc;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('images/labs', 'public');
            $holidays->avatar = $avatarPath;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath[] = $image->store('images/labs', 'public');
            }
            $holidays->images = json_encode($imagePath);
        }

        $holidays->save();

        return redirect()->route('holidays.index')->with('success', 'Holiday created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Holiday $holiday)
    {
        return view('holidays.show', compact('holiday'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Holiday $holiday)
    {
        return view('holidays.edit', compact('holiday'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Holiday $holiday)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:beach,mountain,city',
            'avatar' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'color' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'in_stock' => 'nullable|integer|min:0',
            'condition' => 'required|in:new,old',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'desc' => 'nullable|string|max:1000'
        ]);

        $holiday->update($request->all());

        return redirect()->route('holidays.index')->with('success', 'Holiday updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();

        return redirect()->route('holidays.index')->with('success', 'Holiday deleted successfully.');
    }
}
