<?php 

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrganizerRegisteredMail;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ApiResponseErrorResource;
use App\Http\Resources\ApiResponseSuccessResource;

class AuthController extends Controller
{
    public function registerOrganizer(Request $request)
    {
        try {
            // Validasi inputan
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email:rfc,dns|unique:users,email', // Validasi email lebih ketat
            ]);

            // Generate password random
            $randomPassword = Str::random(12); // Password acak sepanjang 12 karakter

            // Buat user dengan role 'organizer'
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($randomPassword), // Hash password
                'role' => 'organizer',
            ]);
            $user->markEmailAsVerified();

            // Kirim email berisi password kepada user
            Mail::to($user->email)->send(new OrganizerRegisteredMail($user, $randomPassword)); // Mengirimkan email

            // Kembalikan respons sukses
            return (new ApiResponseSuccessResource('Organizer account and event created successfully!', [
                'user' => $user,
                'password' => $randomPassword
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
