<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = $request->user()->school_id;

        $query = StorageLocation::where('school_id', $schoolId)
            ->withCount('items as current_usage');

        if ($request->filled('labType')) {
            $query->where('lab_type', $request->labType);
        }

        return response()->json($query->orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $this->authorize('create', StorageLocation::class);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:shelf,drawer,bench,cabinet',
            'labType' => 'required|in:chemistry,physics,biology,agriculture',
            'capacity' => 'required|integer|min:1',
        ]);

        $location = StorageLocation::create([
            'school_id' => $request->user()->school_id,
            'name' => $data['name'],
            'type' => $data['type'],
            'lab_type' => $data['labType'],
            'capacity' => $data['capacity'],
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
       $this->authorize('update', $storageLocation);

        $storageLocation->update(
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'type' => 'sometimes|required|in:shelf,drawer,bench,cabinet',
                'labType' => 'sometimes|required|in:chemistry,physics,biology,agriculture',
                'capacity' => 'sometimes|required|integer|min:1',
            ])
        );

        return response()->json($storageLocation->loadCount('items'));
    }

    public function destroy(Location $location)
    {
        $user = request()->user();
        if (!$user->is_school_admin || $location->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage locations.'], 403);
        }

               $this->authorize('delete', $storageLocation);

        if ($storageLocation->items()->exists()) {
            return response()->json([
                'message' => 'Cannot delete location with items inside'
            ], 422);
        }

        $storageLocation->delete();

        return response()->json(['message' => 'Location deleted']);

    }
}
