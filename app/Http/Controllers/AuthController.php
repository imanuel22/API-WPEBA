<?php 

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ResponsiblePerson;
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
                'ktp_p' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10240', // Validasi file KTP
                'nama_p' => 'required|string|max:255',
                'alamat_p' => 'required|string|max:255',
                'no_telp_p' => 'required|string|max:15',
            ]);

            // Generate password acak
            $randomPassword = Str::random(12); 

            // Buat user dengan role 'organizer'
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($randomPassword), // Hash password
                'role' => 'organizer',
            ]);

            // Tandai email sebagai terverifikasi
            $user->markEmailAsVerified();
            
            // Kirimkan email pendaftaran organizer
            Mail::to($user->email)->send(new OrganizerRegisteredMail($user, $randomPassword)); // Mengirimkan email

            // Periksa apakah file KTP ada dan simpan
            if ($request->hasFile('ktp_p') && $request->file('ktp_p')->isValid()) {
                $basenamektp = basename($request->file('ktp_p')->store('ktp', 'public'));

                // Membuat data ResponsiblePerson
                ResponsiblePerson::create([
                    'user_id' => $user->id,
                    'nama' => $request->nama_p,
                    'alamat' => $request->alamat_p,
                    'no_telp' => $request->no_telp_p,
                    'foto_ktp' => $basenamektp,
                ]);
            } else {
                throw new \Exception('Invalid or missing KTP file');
            }

            // Kembalikan respons sukses
            return (new ApiResponseSuccessResource('Organizer account and event created successfully!', [
                'user' => $user,
                'password' => $randomPassword
            ], 201))->response();

        } catch (ValidationException $e) {
            // Tangani kesalahan validasi
            return (new ApiResponseErrorResource('Validation error', $e->errors(), 422))->response();
        } catch (\Exception $e) {
            // Tangani kesalahan umum
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
