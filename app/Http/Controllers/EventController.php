<?php
namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return new EventResource(true, 'List of Events', $events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $event = Event::create($request->all());

        return new EventResource(true, 'Event Created Successfully', $event);
    }

    public function show(Event $event)
    {
        return new EventResource(true, 'Event Details', $event);
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'string',
            'location' => 'string',
            'date' => 'date',
            'time' => 'date_format:H:i',
        ]);

        $event->update($request->all());

        return new EventResource(true, 'Event Updated Successfully', $event);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return new EventResource(true, 'Event Deleted Successfully', null);
    }
}
