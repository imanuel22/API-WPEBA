<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Registration;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ApiResponseSuccessResource;
use App\Http\Resources\ApiResponseErrorResource;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    // Method to display all registrations
    public function index()
    {
        try {
            $registrations = Registration::with(['user', 'ticket'])->get(); // Retrieve all registrations with user and ticket relationships
            return (new ApiResponseSuccessResource('List of Registrations', $registrations))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', ['error' => $e->getMessage()], 500))->response();
        }
    }

    // Method to store a new registration
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'user_id' => 'required|exists:users,id', // Ensure user exists
                'ticket_id' => 'required|exists:tickets,id', // Ensure ticket exists
                'status' => 'nullable|in:pending',
                'total_price' => 'required|integer',
                'image_payment' => 'required|image|mimes:jpeg,png,jpg|max:500',
            ]);

            $registrationData = $request->only(['user_id', 'ticket_id', 'status', 'total_price']);
            $registrationData['registration_date'] = now(); // Set the registration date to current timestamp

            // Handle image payment upload if provided
            if ($request->hasFile('image_payment')) {
                $registrationData['image_payment'] = basename($request->file('image_payment')->store('payments', 'public'));
            }

            // Create the registration record
            $registration = Registration::create($registrationData);

            return (new ApiResponseSuccessResource('Registration Created Successfully', $registration, 201))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    // Method to show a specific registration's details
    public function show($id)
    {
        try {
            $registration = Registration::with(['user', 'ticket'])->findOrFail($id); // Retrieve the registration by ID with user and ticket
            return (new ApiResponseSuccessResource('Registration Details', $registration))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Registration Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }

    public function update(Request $request, $id) {
        
    }


    // Method to update an existing registration
public function verification(Request $request, $id)
{
    try {
        // Validate the request data to allow only 'confirmed' or 'cancelled' statuses
        $request->validate([
            
            'status' => 'required|in:confirmed,cancelled',
        ]);

        // Find the registration by ID
        $registration = Registration::findOrFail($id);
        
        // If status is 'cancelled', remove the payment image from storage if it exists
        // if ($request->status === 'cancelled' && $registration->image_payment) {
        //     if (Storage::exists('public/payments/' . $registration->image_payment)) {
        //         Storage::delete('public/payments/' . $registration->image_payment);
        //     }
        //     $registration->image_payment = null; // Set image_payment to null
        // }

        // Update only the status field
        $registration->status = $request->status;
        $registration->save();

        return (new ApiResponseSuccessResource('Registration status updated successfully', $registration))->response();
    } catch (ValidationException $e) {
        return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
    } catch (Exception $e) {
        return (new ApiResponseErrorResource('An error occurred', ['error' => $e->getMessage()], 500))->response();
    }
}


    // Method to delete a registration
    public function destroy($id)
    {
        try {
            // Find the registration by ID
            $registration = Registration::findOrFail($id);

            // Delete the associated image payment from storage if exists
            if ($registration->image_payment && Storage::exists('public/payments/' . $registration->image_payment)) {
                Storage::delete('public/payments/' . $registration->image_payment);
            }

            // Delete the registration record
            $registration->delete();

            return (new ApiResponseSuccessResource('Registration Deleted Successfully', null))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Registration Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }
}
