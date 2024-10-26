<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return Event::all();
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

        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        return response()->json($event);
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

        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->noContent();
    }
}
