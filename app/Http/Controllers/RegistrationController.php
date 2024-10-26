<?php
namespace App\Http\Controllers;

use App\Http\Resources\RegistrationResource;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::all();
        return new RegistrationResource(true, 'List of Registrations', $registrations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'status' => 'required|string'
        ]);

        $registration = Registration::create($request->all());

        return new RegistrationResource(true, 'Registration Created Successfully', $registration);
    }

    public function show(Registration $registration)
    {
        return new RegistrationResource(true, 'Registration Details', $registration);
    }

    public function update(Request $request, Registration $registration)
    {
        $request->validate([
            'status' => 'string'
        ]);

        $registration->update($request->only(['status']));

        return new RegistrationResource(true, 'Registration Updated Successfully', $registration);
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();

        return new RegistrationResource(true, 'Registration Deleted Successfully', null);
    }
}
