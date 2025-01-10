<?php
namespace App\Http\Controllers;

use Exception;
use App\Models\Ticket;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResponseSuccessResource;
use App\Http\Resources\ApiResponseErrorResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    // Method to display all tickets
    public function index()
    {
        try {
            $tickets = Ticket::with('event')->get(); // Retrieve all tickets
            return (new ApiResponseSuccessResource('List of Tickets', $tickets))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', ['error' => $e->getMessage()], 500))->response();
        }
    }

    // Method to store a new ticket
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'event_id' => 'required|exists:events,id', // Ensure event exists
                'name' => 'required|string|max:255',
                'price' => 'required|integer',
                'quantity' => 'required|integer',
                'payment_method'=>'required|string',
                'payment_number'=>'required|string',
                'payment_name'=>'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Handle image upload
            $ticketData = $request->only(['event_id', 'name', 'price', 'quantity','payment_method','payment_number','payment_name']);
            $ticketData['image'] = basename($request->file('image')->store('tickets', 'public'));

            // Create the ticket record
            $ticket = Ticket::create($ticketData);

            return (new ApiResponseSuccessResource('Ticket Created Successfully', $ticket, 201))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    // Method to show a specific ticket's details
    public function show($id)
    {
        try {
            $ticket = Ticket::with('event')->findOrFail($id); // Retrieve the ticket by ID
            return (new ApiResponseSuccessResource('Ticket Details', $ticket))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Ticket Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }

    // Method to update an existing ticket
    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'name' => 'nullable|string|max:255',
                'price' => 'nullable|integer',
                'quantity' => 'nullable|integer',
                'payment_method'=>'required|string',
                'payment_number'=>'required|string',
                'payment_name'=>'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Find the ticket by ID
            $ticket = Ticket::findOrFail($id);

            // Handle image update if present
            if ($request->hasFile('image')) {
                // Delete the old image from storage if exists
                if ($ticket->image && Storage::exists('public/tickets/' . $ticket->image)) {
                    Storage::delete('public/tickets/' . $ticket->image);
                }

                // Store the new image
                $ticket->image = basename($request->file('image')->store('tickets', 'public'));
            }

            // Update ticket with the provided data
            $ticket->update($request->only(['name', 'price', 'quantity','payment_method','payment_number','payment_name']));

            return (new ApiResponseSuccessResource('Ticket Updated Successfully', $ticket))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    // Method to delete a ticket
    public function destroy($id)
    {
        try {
            // Find the ticket by ID
            $ticket = Ticket::findOrFail($id);

            // Delete the associated image from storage if exists
            if ($ticket->image && Storage::exists('public/tickets/' . $ticket->image)) {
                Storage::delete('public/tickets/' . $ticket->image);
            }

            // Delete the ticket record
            $ticket->delete();

            return (new ApiResponseSuccessResource('Ticket Deleted Successfully', null))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Ticket Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }
}
