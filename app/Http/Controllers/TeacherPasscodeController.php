<?php

namespace App\Http\Controllers;

use App\Models\TeacherPasscode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeacherPasscodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user->is_school_admin) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage teacher passcodes.'], 403);
        }

        if (!$user->school_id) {
            return response()->json(['error' => 'User does not have an associated school'], 400);
        }

        $passcodes = TeacherPasscode::where('school_id', $user->school_id)->get();
        return response()->json($passcodes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user->is_school_admin) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage teacher passcodes.'], 403);
        }

        if (!$user->school_id) {
            return response()->json(['error' => 'User does not have an associated school'], 400);
        }

        $request->validate([
            'teacher_name' => 'required|string',
            'permissions' => 'nullable|array',
        ]);

        $passcode = Str::random(8); // Generate 8-character passcode

        $teacherPasscode = TeacherPasscode::create([
            'school_id' => $user->school_id,
            'passcode' => $passcode,
            'teacher_name' => $request->teacher_name,
            'permissions' => $request->permissions ?? [],
            'created_by' => $user->id,
        ]);

        return response()->json($teacherPasscode, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $passcode = TeacherPasscode::findOrFail($id);
        $user = request()->user();
        if (!$user->is_school_admin || $passcode->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($passcode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $passcode = TeacherPasscode::findOrFail($id);
        $user = $request->user();
        if (!$user->is_school_admin || $passcode->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'teacher_name' => 'sometimes|string',
            'permissions' => 'sometimes|array',
            'is_active' => 'sometimes|boolean',
        ]);

        $passcode->update($request->only(['teacher_name', 'permissions', 'is_active']));
        return response()->json($passcode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $passcode = TeacherPasscode::findOrFail($id);
        $user = request()->user();
        if (!$user->is_school_admin || $passcode->school_id !== $user->school_id) {
            return response()->json(['error' => 'Unauthorized. Only school administrators can manage teacher passcodes.'], 403);
        }

        $passcode->delete();
        return response()->json(['message' => 'Passcode deleted']);
    }
}
