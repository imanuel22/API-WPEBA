<?php
namespace App\Http\Controllers;

use Exception;
use App\Models\Information;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResponseSuccessResource;
use App\Http\Resources\ApiResponseErrorResource;
use App\Http\Resources\ApiResponseResource;
use Illuminate\Validation\ValidationException;

class InformationController extends Controller
{
    // Method to display all information records
    public function index()
    {
        try {
            $information = Information::all(); // Retrieve all information records
            return (new ApiResponseSuccessResource('List of Information', $information))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', ['error' => $e->getMessage()], 500))->response();
        }
    }

    // Method to store new information record
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'event_id' => 'required|exists:events,id',  // Ensure event exists
                'whatapps' => 'nullable|numeric|min:15',
                'telephone' => 'nullable|numeric|min:15',
                'facebook' => 'nullable|string|max:100',
                'instagram' => 'nullable|string|max:100',
                'email' => 'nullable|string|email|max:100',
                'website' => 'nullable|string|max:100',
            ]);

            // Store the new information record
            $information = Information::create($request->only([
                'event_id', 'whatapps', 'telephone', 'facebook', 'instagram', 'email', 'website'
            ]));

            return (new ApiResponseSuccessResource('Information Created Successfully', $information, 201))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    // Method to show specific information record details
    public function show($id)
    {
        try {
            $information = Information::findOrFail($id); // Retrieve the information by ID
            return (new ApiResponseSuccessResource('Information Details', $information))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Information Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }

    // Method to update a specific information record
    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'whatapps' => 'nullable|string|max:15',
                'telephone' => 'nullable|string|max:15',
                'facebook' => 'nullable|string|max:100',
                'instagram' => 'nullable|string|max:100',
                'email' => 'nullable|string|email|max:100',
                'website' => 'nullable|string|max:100',
            ]);

            // Find the information record by ID
            $information = Information::findOrFail($id);

            // Update the information record with the new data
            $information->update($request->only([
                'whatapps', 'telephone', 'facebook', 'instagram', 'email', 'website'
            ]));

            return (new ApiResponseSuccessResource('Information Updated Successfully', $information))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    // Method to delete a specific information record
    public function destroy($id)
    {
        try {
            // Find the information record by ID
            $information = Information::findOrFail($id);

            // Delete the information record
            $information->delete();

            return (new ApiResponseSuccessResource('Information Deleted Successfully', null))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Information Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }
}
