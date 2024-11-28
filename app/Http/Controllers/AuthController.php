<?php 

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ResponsiblePerson;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrganizerRegisteredMail;
use Tymon\JWTAuth\Exceptions\JWTException;
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
        return redirect()->to(env('WEB_URL').'/login');
    }

    public function registerParticipant(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password' => 'required|min:8',
                'role' => 'nullable|in:participant',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg|max:500',
            ]);

            $userData = $request->only(['name', 'email']);
            $userData['role'] = $request->role ?? 'participant';
            $userData['password'] = Hash::make($request->password);

            if ($request->hasFile('profile')) {
                $userData['profile'] = basename($request->file('profile')->store('user', 'public'));
            }

        $user = User::create($userData); // Create the user
        $user->sendEmailVerificationNotification(); // Send email verification

            return (new ApiResponseSuccessResource('User Registered Successfully', $user, 201))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Periksa apakah pengguna ada di database
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email is not registered',
                'data' => ['email' => $request->email],
            ], 404);
        }

        // Periksa apakah email telah diverifikasi
        if (is_null($user->email_verified_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Email has not been verified',
                'data' => ['email' => $request->email],
            ], 403); // 403 Forbidden
        }

        // Verifikasi password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        try {
            // Coba buat token JWT
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create token, please try again later.',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'data' => $user->only(['id', 'name', 'email', 'role', 'profile']),
        ], 200);
    }


   public function refresh()
    {
        try {
            // Periksa apakah token ada
            if (!$token = JWTAuth::getToken()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token not provided',
                    'data' => [],
                ], 400); // 400 Bad Request
            }

            // Refresh token
            $newToken = JWTAuth::refresh($token);

            return response()->json([
                'success' => true,
                'message' => 'Token refreshed successfully',
                'token' => $newToken,
                'data' => [],
            ], 200); // 200 OK
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token has expired and cannot be refreshed',
                'data' => $e->getMessage(),
            ], 401); // 401 Unauthorized
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid',
                'data' => $e->getMessage(),
            ], 401); // 401 Unauthorized
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not refresh token',
                'data' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

    public function logout(Request $request)
    {
        try {
            // Periksa apakah token disertakan
            if (!$token = JWTAuth::getToken()) {
                return (new ApiResponseErrorResource('Token not provided', null, 400))->response();
            }

            // Invalidasi token
            JWTAuth::invalidate($token);

            return (new ApiResponseSuccessResource('Successfully logged out', null, 200))->response();
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return (new ApiResponseErrorResource('Invalid token', $e->getMessage(), 401))->response();
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return (new ApiResponseErrorResource('Token could not be invalidated', $e->getMessage(), 500))->response();
        } catch (\Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }
}
