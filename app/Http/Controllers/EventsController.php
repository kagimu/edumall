<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Events::all();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    public function getEvents()
    {
        $events = Events::all();
        return response()->json($events);
    }

    public function getEventsByCategory($category)
    {
        $events = Events::where('category', $category)->get();
        return response()->json($events);
    }

    public function getEventsById($id)
    {
        $events = Events::find($id);
        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:sound,tents',
            'avatar' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'color' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'in_stock' => 'nullable|integer|min:0',
            'condition' => 'required|in:new,old',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'desc' => 'nullable|string|max:1000',
        ]);

        $events = Events::create($request->all());

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Events $events)
    {
        return view('events.show', compact('events'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Events $events)
    {
        return view('events.edit', compact('events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Events $events)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:sound,tents',
            'avatar' => 'nullable|image|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'color' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'in_stock' => 'nullable|integer|min:0',
            'condition' => 'required|in:new,old',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'desc' => 'nullable|string|max:1000',
        ]);

        $events->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Events $events)
    {
        $events->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
