<?php 

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ApiResponseSuccessResource;
use App\Http\Resources\ApiResponseErrorResource;

class AuthController extends Controller
{
    /**
     * Register a new organizer and create an event associated with the organizer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerOrganizer(Request $request)
    {
        try {
            // Validasi inputan
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'title' => 'required|string|max:255',
            ]);

            // Buat user dengan role 'organizer'
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'organizer',
            ]);

            // Buat event yang terkait dengan user yang baru dibuat
            $event = Event::create([
                'title' => $request->title,
                'user_id' => $user->id,
                'status' => 'upcoming',  // Set status default event
            ]);

            return (new ApiResponseSuccessResource('Organizer account and event created successfully!', [
                'user' => $user,
                'event' => $event
            ], 201))->response();

        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation error', $e->errors(), 422))->response();
        } catch (\Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    public function verify($id, Request $request){
        if (!$request->hasValidSignature()) {
            return response()->json([
                'status'=>false,
                'message'=>'Verifikasi email gagal',
            ],400);
        }
        $user = User::findOrFail($id);

        if(!$user->hasVerifiedEmail()){
            $user->markEmailAsVerified();
        }
        return redirect()->to('/');
    }

    // public function resean() {
        
    // }
}
