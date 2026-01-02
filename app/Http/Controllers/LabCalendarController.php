<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LabCalendarController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = $request->user()->school_id;

        return response()->json([
            'sessions' => LabSession::where('school_id', $schoolId)
                ->orderBy('start_date')
                ->get(),

            'transactions' => InventoryTransaction::with('item')
                ->where('school_id', $schoolId)
                ->orderBy('date')
                ->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', LabSession::class);

        $data = $request->validate([
            'title' => 'required|string',
            'type' => 'required',
            'labType' => 'required',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate',
            'startTime' => 'required',
            'endTime' => 'required',
            'students' => 'nullable|integer|min:0',
            'instructor' => 'nullable|string',
        ]);

        $session = LabSession::create([
            'school_id' => $request->user()->school_id,
            'created_by' => $request->user()->id,
            'title' => $data['title'],
            'type' => $data['type'],
            'lab_type' => $data['labType'],
            'description' => $data['description'] ?? null,
            'notes' => $data['notes'] ?? null,
            'start_date' => $data['startDate'],
            'end_date' => $data['endDate'],
            'start_time' => $data['startTime'],
            'end_time' => $data['endTime'],
            'students' => $data['students'] ?? 0,
            'instructor' => $data['instructor'] ?? null,
        ]);

        return response()->json($session, 201);
    }

    public function update(Request $request, LabSession $labSession)
    {
        $this->authorize('update', $labSession);

        $labSession->update($request->only([
            'title',
            'type',
            'labType',
            'description',
            'notes',
            'startDate',
            'endDate',
            'startTime',
            'endTime',
            'students',
            'instructor',
        ]));

        return response()->json($labSession);
    }

    public function destroy(LabSession $labSession)
    {
        $this->authorize('delete', $labSession);

        $labSession->delete();

        return response()->json(['message' => 'Session deleted']);
    }
}

