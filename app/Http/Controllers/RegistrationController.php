<?php
namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        return Registration::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'registration_date' => 'nullable|date',
            'status' => 'in:pending,confirmed,cancelled',
            'payment_status' => 'in:unpaid,paid',
        ]);

        $registration = Registration::create($request->all());

        return response()->json($registration, 201);
    }

    public function show(Registration $registration)
    {
        return response()->json($registration);
    }

    public function update(Request $request, Registration $registration)
    {
        $request->validate([
            'status' => 'in:pending,confirmed,cancelled',
            'payment_status' => 'in:unpaid,paid',
        ]);

        $registration->update($request->all());

        return response()->json($registration);
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();
        return response()->noContent();
    }
}
