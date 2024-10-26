<?php
namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    public function index()
    {
        return Speaker::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string',
            'topic' => 'required|string',
        ]);

        $speaker = Speaker::create($request->all());

        return response()->json($speaker, 201);
    }

    public function show(Speaker $speaker)
    {
        return response()->json($speaker);
    }

    public function update(Request $request, Speaker $speaker)
    {
        $request->validate([
            'name' => 'string',
            'topic' => 'string',
        ]);

        $speaker->update($request->all());

        return response()->json($speaker);
    }

    public function destroy(Speaker $speaker)
    {
        $speaker->delete();
        return response()->noContent();
    }
}
