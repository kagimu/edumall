<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::all();
        return response()->json(['schools' => $schools]);
    }

    public function update(Request $request, School $school)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $school->update(['status' => $request->status]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'School status updated successfully.', 'school' => $school]);
        }

        return redirect()->back()->with('success', 'School status updated successfully.');
    }
}
