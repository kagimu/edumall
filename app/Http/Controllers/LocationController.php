<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user->is_school_admin) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage locations.'], 403);
        }

        if (!$user->school_id) {
            return response()->json(['error' => 'User does not have an associated school'], 400);
        }

        $locations = Location::where('school_id', $user->school_id)->get();
        return response()->json($locations);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user->is_school_admin) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage locations.'], 403);
        }

        if (!$user->school_id) {
            return response()->json(['error' => 'User does not have an associated school'], 400);
        }

        $request->validate([
            'name' => 'required|string|unique:locations,name,NULL,id,school_id,' . $user->school_id,
            'description' => 'nullable|string',
        ]);

        $location = Location::create([
            'school_id' => $user->school_id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json($location, 201);
    }

    public function show(Location $location)
    {
        $user = request()->user();
        if (!$user->is_school_admin || $location->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage locations.'], 403);
        }

        return response()->json($location);
    }

    public function update(Request $request, Location $location)
    {
        $user = $request->user();
        if (!$user->is_school_admin || $location->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage locations.'], 403);
        }

        $request->validate([
            'name' => 'required|string|unique:locations,name,' . $location->id . ',id,school_id,' . $user->school_id,
            'description' => 'nullable|string',
        ]);

        $location->update($request->only(['name', 'description']));
        return response()->json($location);
    }

    public function destroy(Location $location)
    {
        $user = request()->user();
        if (!$user->is_school_admin || $location->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage locations.'], 403);
        }

        $location->delete();
        return response()->json(['message' => 'Location deleted']);
    }
}
