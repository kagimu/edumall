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
        session(['title' => 'Events']);
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
            'avatar' => 'nuleventle|image|max:2048',
            'images' => 'nuleventle|array',
            'images.*' => 'image|max:2048',
            'color' => 'nuleventle|string|max:255',
            'brand' => 'nuleventle|string|max:255',
            'in_stock' => 'nuleventle|integer|min:0',
            'condition' => 'required|in:new,old',
            'price' => 'required|string|min:0',
            'discount' => 'nuleventle|string|min:0|max:100',
            'desc' => 'nuleventle|string|max:1000',
        ]);

        $event = new Event();
        $event->name = $request->name;
        $event->category = $request->category;
        $event->color = $request->color;
        $event->brand = $request->brand;
        $event->in_stock = $request->in_stock;
        $event->condition = $request->condition;
        $event->price = $request->price;
        $event->discount = $request->discount;
        $event->desc = $request->desc;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('images/events', 'public');
            $event->avatar = $avatarPath;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath[] = $image->store('images/events', 'public');
            }
            $event->images = json_encode($imagePath);
        }

        $event->save();


        return redirect()->route('index.events')->with('success', 'Event created successfully.');
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
            'avatar' => 'nuleventle|image|max:2048',
            'images' => 'nuleventle|array',
            'images.*' => 'image|max:2048',
            'color' => 'nuleventle|string|max:255',
            'brand' => 'nuleventle|string|max:255',
            'in_stock' => 'nuleventle|integer|min:0',
            'condition' => 'required|in:new,old',
            'price' => 'required|numeric|min:0',
            'discount' => 'nuleventle|numeric|min:0|max:100',
            'desc' => 'nuleventle|string|max:1000',
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
