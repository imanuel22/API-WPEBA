<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada
use Illuminate\Support\Facades\Validator; // Untuk Validator jika diperlukan
use App\Http\Resources\ApiResponseErrorResource; // Jika menggunakan ApiResponseErrorResource
use App\Http\Resources\ApiResponseSuccessResource; // Jika menggunakan ApiResponseSuccessResource


class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            return (new ApiResponseSuccessResource('List of Users', $users))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', ['error' => $e->getMessage()], 500))->response();
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password' => 'required|min:8',
                'role' => 'required|in:admin,participant,organizer',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg|max:500',
            ]);

            $userData = $request->only(['name', 'email', 'role']);
            $userData['password'] = Hash::make($request->password);

            if ($request->hasFile('profile')) {
                $userData['profile'] = basename($request->file('profile')->store('user', 'public'));
            }

            $user = User::create($userData);

            return (new ApiResponseSuccessResource('User Created Successfully', $user, 201))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->profile = $user->profile ? url('storage/user/' . $user->profile) : null;
            return (new ApiResponseSuccessResource('User Details', $user))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('User Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $id,
                'role' => 'nullable|in:admin,participant,organizer',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg|max:500',
            ]);

            $user = User::findOrFail($id);

            $userData = $request->only(['name', 'email', 'role']);

            // Handle profile picture update
            if ($request->hasFile('profile')) {
                if ($user->profile && Storage::exists('public/user/' . $user->profile)) {
                    Storage::delete('public/user/' . $user->profile);
                }

                $userData['profile'] = basename($request->file('profile')->store('user', 'public'));
            }

            $user->update($userData);

            return (new ApiResponseSuccessResource('User Updated Successfully', $user))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', $e->getMessage(), 500))->response();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Delete profile image if it exists
            if ($user->profile && Storage::exists('public/user/' . $user->profile)) {
                Storage::delete('public/user/' . $user->profile);
            }

            $user->delete();

            return (new ApiResponseSuccessResource('User Deleted Successfully', null))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('User Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }

    public function register(Request $request)
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

        // Check if the user exists in the database
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email is not registered',
                'data' => ['email'=>$request->email,'user'=>$user],
            ], 404);
        }

        // Verify the password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        try {
            // Try to create JWT token
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
            'data' => $user->only(['id', 'name', 'email', 'role','profile']),
        ], 200);
    }

    public function refresh()
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json([
                'success' => true,
                'token' => $newToken,
                'data' => [],
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not refresh token',
                'data' => $e->getMessage(),
            ], 500);
        }
    }
}
