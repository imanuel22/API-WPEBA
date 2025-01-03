<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ApiResponseErrorResource;
use App\Http\Resources\ApiResponseSuccessResource;

class DocumentationController extends Controller
{
    /**
     * Display a listing of the documentation.
     */
    public function index()
    {
        try {
            $documentations = Documentation::with('event')->get();
            return (new ApiResponseSuccessResource('List of Documentations', $documentations))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', ['error' => $e->getMessage()], 500))->response();
        }
    }

    /**
     * Store a newly created documentation in storage.
     */
    public function store(Request $request)
    {
        try {
            $existingCount = Documentation::where('event_id', $request->event_id)->count();
            if ($existingCount >= 5) {
                return (new ApiResponseErrorResource(
                    'You can only store up to 5 documentations per event.',
                    [],
                    403 
                ))->response();
            }
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'required|string',
                'event_id' => 'required|exists:events,id',
            ]);

            $data = $request->only(['description', 'event_id']);

            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = basename($request->file('image')->store('documentations', 'public'));
            }

            $documentation = Documentation::create($data);

            return (new ApiResponseSuccessResource('Documentation Created Successfully', $documentation, 201))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    /**
     * Display the specified documentation.
     */
    public function show($id)
    {
        try {
            $documentation = Documentation::with('event')->findOrFail($id);
            $documentation->image = $documentation->image ? url('storage/documentations/' . $documentation->image) : null;
            return (new ApiResponseSuccessResource('Documentation Details', $documentation))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Documentation Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }

    /**
     * Update the specified documentation in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'description' => 'nullable|string',
                'event_id' => 'nullable|exists:events,id',
            ]);

            $documentation = Documentation::findOrFail($id);
            $data = $request->only(['description', 'event_id']);

            // Handle image update
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($documentation->image && Storage::exists('public/documentations/' . $documentation->image)) {
                    Storage::delete('public/documentations/' . $documentation->image);
                }

                $data['image'] = basename($request->file('image')->store('documentations', 'public'));
            }

            $documentation->update($data);
            
            return (new ApiResponseSuccessResource('Documentation Updated Successfully', $documentation))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    /**
     * Remove the specified documentation from storage.
     */
    public function destroy($id)
    {
        try {
            $documentation = Documentation::findOrFail($id);

            // Delete image if exists
            if ($documentation->image && Storage::exists('public/documentations/' . $documentation->image)) {
                Storage::delete('public/documentations/' . $documentation->image);
            }

            $documentation->delete();

            return (new ApiResponseSuccessResource('Documentation Deleted Successfully', null))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Documentation Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }
}
