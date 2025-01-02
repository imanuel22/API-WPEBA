<?php
namespace App\Http\Controllers;

use Exception;
use App\Models\Event;
use App\Models\Image;
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
                'documentations',
                'images'
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
            'status' => 'nullable|in:upcoming',
            'start_datetime' => 'nullable|date',
            'duration' => 'nullable|integer',
            'location' => 'nullable|string',
            'contact' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'event_category_ids' => 'nullable|array|exists:category,id',
            'images' => 'nullable|array|max:5', // Allow up to 5 images
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048', // Each image must be a valid image file
        ]);

        $eventData = $request->only(['title', 'description', 'status', 'start_datetime', 'duration', 'location', 'contact', 'user_id']);
        $event = Event::create($eventData);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                if ($key < 5) { // Maximum 5 images
                    $filename = basename($image->store('event', 'public'));
                    $imageModel = Image::create(['filename' => $filename]);
                    $event->images()->attach($imageModel->id);
                }
            }
        }

        if ($request->has('event_category_ids')) {
            $event->categories()->sync($request->event_category_ids);
        }

        return (new ApiResponseSuccessResource('Event Created Successfully', $event->load('images'), 201))->response();
    } catch (ValidationException $e) {
        return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
    }catch (Exception $e) {
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
            'documentations',
            'images'
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:500',
            'status' => 'nullable|in:upcoming,in_progress,completed',
            'start_datetime' => 'nullable|date',
            'duration' => 'nullable|integer',
            'location' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'event_category_ids' => 'nullable|array|exists:category,id',
        ]);

        $event = Event::findOrFail($id);

        if ($request->has('images')) {
            // Hapus gambar lama
            $event->images->each(function ($image) {
                if (Storage::exists('public/event/' . $image->filename)) {
                    Storage::delete('public/event/' . $image->filename);
                }
                $image->delete(); // Hapus dari database
            });

            // Simpan gambar baru
            foreach ($request->file('images') as $key => $image) {
                if ($key < 5) {
                    $filename = basename($image->store('event', 'public'));
                    $imageModel = Image::create(['filename' => $filename]);
                    $event->images()->attach($imageModel->id);
                }
            }
        }

        $event->update($request->only(['title', 'description', 'status', 'start_datetime', 'duration', 'location', 'contact', 'user_id']));

        if ($request->has('event_category_ids')) {
            $event->categories()->sync($request->event_category_ids);
        }

        return (new ApiResponseSuccessResource('Event Updated Successfully', $event->load('images')))->response();
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

        $event->images->each(function ($image) {
            if (Storage::exists('public/event/' . $image->filename)) {
                Storage::delete('public/event/' . $image->filename);
            }
            $image->delete(); // Hapus dari database
        });

        $event->delete();

        return (new ApiResponseSuccessResource('Event Deleted Successfully', null))->response();
    } catch (Exception $e) {
        return (new ApiResponseErrorResource('Event Not Found', ['error' => $e->getMessage()], 404))->response();
    }
}

}
