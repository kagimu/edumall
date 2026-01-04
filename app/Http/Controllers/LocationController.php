<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = $request->user()->school_id;

        $query = Location::where('school_id', $schoolId)
            ->withCount('items as current_usage');

        if ($request->filled('labType')) {
            $query->where('lab_type', $request->labType);
        }

        return response()->json($query->orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!$user->school_id) {
            return response()->json(['error' => 'User does not have an associated school'], 400);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $location = Location::create([
            'school_id' => $user->school_id,
            'name' => $data['name'],
            'type' => $request->type ?? 'shelf',
            'lab_type' => $request->labType ?? 'chemistry',
            'capacity' => $request->capacity ?? 100,
        ]);

        return response()->json($location->loadCount('items'), 201);
    }

    public function show(Location $location)
    {
        $user = request()->user();
        return response()->json($location);
    }

    public function update(Request $request, Location $location)
    {
       $this->authorize('update', $location);

        $location->update(
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'type' => 'sometimes|required|in:shelf,drawer,bench,cabinet',
                'labType' => 'sometimes|required|in:chemistry,physics,biology,agriculture',
                'capacity' => 'sometimes|required|integer|min:1',
            ])
        );

        return response()->json($location->loadCount('items'));
    }

    public function destroy(Location $location)
    {
        $user = request()->user();
        if (!$user || $user->role_id !== 1 || $location->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage locations.'], 403);
        }

               $this->authorize('delete', $location);

        if ($location->items()->exists()) {
            return response()->json([
                'message' => 'Cannot delete location with items inside'
            ], 422);
        }

        $location->delete();

        return response()->json(['message' => 'Location deleted']);

    }
}
