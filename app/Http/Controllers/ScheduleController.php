<?php
namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return Schedule::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'session_name' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'description' => 'nullable|string',
        ]);

        $schedule = Schedule::create($request->all());

        return response()->json($schedule, 201);
    }

    public function show(Schedule $schedule)
    {
        return response()->json($schedule);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'session_name' => 'string',
            'start_time' => 'date_format:H:i',
            'end_time' => 'date_format:H:i',
            'description' => 'string',
        ]);

        $schedule->update($request->all());

        return response()->json($schedule);
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return response()->noContent();
    }
}
