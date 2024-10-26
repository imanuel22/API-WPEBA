<?php
namespace App\Http\Controllers;

use App\Http\Resources\SpeakerResource;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpeakerController extends Controller
{
    public function index()
    {
        $speakers = Speaker::all();
        return new SpeakerResource(true, 'List of Speakers', $speakers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'biography' => 'string|nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $speakerData = $request->only(['name', 'biography']);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('images/speakers', 'public');
            $speakerData['photo'] = $path;
        }

        $speaker = Speaker::create($speakerData);

        return new SpeakerResource(true, 'Speaker Created Successfully', $speaker);
    }

    public function show(Speaker $speaker)
    {
        return new SpeakerResource(true, 'Speaker Details', $speaker);
    }

    public function update(Request $request, Speaker $speaker)
    {
        $request->validate([
            'name' => 'string',
            'biography' => 'string|nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $speakerData = $request->only(['name', 'biography']);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('images/speakers', 'public');
            $speakerData['photo'] = $path;
        }

        $speaker->update($speakerData);

        return new SpeakerResource(true, 'Speaker Updated Successfully', $speaker);
    }

    public function destroy(Speaker $speaker)
    {
        if ($speaker->photo) {
            Storage::disk('public')->delete($speaker->photo);
        }

        $speaker->delete();

        return new SpeakerResource(true, 'Speaker Deleted Successfully', null);
    }
}
