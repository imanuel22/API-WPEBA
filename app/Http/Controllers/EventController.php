<?php
namespace App\Http\Controllers;

use Exception;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResponseSuccessResource;
use App\Http\Resources\ApiResponseErrorResource;
use App\Http\Resources\ApiResponseResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        try {
            $events = Event::with([
                'user',
                'information',
                'categories',
                'feedbacks.user',
                'tickets',
                'documentations'
            ])->get();            return (new ApiResponseSuccessResource('List of Events', $events))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', ['error' => $e->getMessage()], 500))->response();
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:500',
                'status' => 'nullable|in:upcoming,in_progress,completed',
                'start_datetime' => 'nullable|date',
                'duration' => 'nullable|integer',
                'location' => 'nullable|string',
                'contact' => 'nullable|string|max:100',
                // 'maps' => 'nullable|string|max:255',
                'user_id' => 'required|exists:users,id',
            'event_category_ids' => 'nullable|array|exists:category,id',
            ]);

            $userData = $request->only(['title', 'description', 'status', 'start_datetime', 'duration', 'location', 'contact', 'maps', 'user_id']);
            if($request->has('image')){

                $userData['image'] = basename($request->file('image')->store('event', 'public'));
            }

            $event = Event::create($userData);

            if ($request->has('event_category_ids')) {
    $event->categories()->sync($request->event_category_ids); // Sync kategori baru
}


            return (new ApiResponseSuccessResource('Event Created Successfully', $event, 201))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    public function show($id)
    {
        try {
            $event = Event::with([
            'user',
            'information',
            'categories',
            'feedbacks.user',
            'tickets',
            'documentations'
        ])->findOrFail($id);
            return (new ApiResponseSuccessResource( 'Event Details', $event))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Event Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }

    public function update(Request $request, $id)
{
    try {
        $request->validate([
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'nullable|in:upcoming,in_progress,completed',
            'start_datetime' => 'nullable|date',
            'duration' => 'nullable|integer',
            'location' => 'nullable|string',
            'contact' => 'nullable|string|max:100',
            'maps' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id',
'event_category_ids' => 'nullable|array|exists:category,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:500',
        ]);

        $event = Event::findOrFail($id);

        // Menangani upload gambar
        if ($request->hasFile('image')) {
            if ($event->image && Storage::exists('public/event/' . $event->image)) {
                Storage::delete('public/event/' . $event->image);
            }

            $event->image = basename($request->file('image')->store('event', 'public'));
        }

        // Update event
        $event->update($request->only([
            'title', 'description', 'status', 'start_datetime', 'duration', 'location', 'contact', 'maps', 'user_id'
        ]));
        
        // Update kategori jika ada
if ($request->has('event_category_ids')) {
    $event->categories()->sync($request->event_category_ids); // Sync kategori baru
}


        return (new ApiResponseSuccessResource('Event Updated Successfully', $event))->response();
    } catch (ValidationException $e) {
        return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
    } catch (Exception $e) {
        return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
    }
}


    public function destroy($id)
    {
        try {
            $event = Event::findOrFail($id);

            if ($event->image && Storage::exists('public/event/' . $event->image)) {
                Storage::delete('public/event/' . $event->image);
            }

            $event->delete();

            return (new ApiResponseSuccessResource( 'Event Deleted Successfully', null))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Event Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }
}
