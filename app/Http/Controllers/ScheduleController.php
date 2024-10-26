<?php
namespace App\Http\Controllers;

use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        return new ScheduleResource(true, 'List of Schedules', $schedules);
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'title' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time'
        ]);

        $schedule = Schedule::create($request->all());

        return new ScheduleResource(true, 'Schedule Created Successfully', $schedule);
    }

    public function show(Schedule $schedule)
    {
        return new ScheduleResource(true, 'Schedule Details', $schedule);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'title' => 'string',
            'start_time' => 'date_format:H:i',
            'end_time' => 'date_format:H:i|after:start_time'
        ]);

        $schedule->update($request->all());

        return new ScheduleResource(true, 'Schedule Updated Successfully', $schedule);
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return new ScheduleResource(true, 'Schedule Deleted Successfully', null);
    }
}
