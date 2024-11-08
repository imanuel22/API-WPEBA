<?php
namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class UserController extends Controller
{
    public function index()
    {
        try{
            $users = User::all();
            return new UserResource(true, 'List of Users', $users);
        }catch (Exception $e) {
            return (new UserResource(false,'An error occurred',$e->getMessage(),500))->response();
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => "required|string",
                'email' => "required|email:rfc,dns|unique:users,email",
                'password' => "required|min:8",
                'role' => 'required|in:admin,participant,organizer',
                'profile' => 'required|image|mimes:jpeg,png,jpg|max:500',
            ]);

            $userData = $request->only(['name', 'email','role']);
            $userData['password'] = Hash::make($request->password);
            $userData['profile'] = basename($request->file('profile')->store('user', 'public'));

            $user = User::create($userData);

            return (new UserResource(true, 'User Created Successfully',$user,201))->response();
        } catch (ValidationException $e) {
            return (new UserResource(false, 'Validation Error', $e->errors(), 422))->response();        
        } catch (Exception $e) {
            return (new UserResource(false,'An error occurred',$e->getMessage(),500))->response();
        }
    }

    public function show(User $user)
    {
        try{
            $user->image = $user->image ? url('storage/user/' . $user->image) : null;
            return new UserResource(true, 'User Details', $user);
        }
        catch (Exception $e) {
            return (new UserResource(false,'An error occurred',$e->getMessage(),500))->response();
        }
    }

    public function update(Request $request, User $user)
    {
        try{
            $request->validate([
                'name' => 'string',
                'email' => 'email|unique:users,email,' . $user->id,
                'role' => 'in:admin,participant,speaker,organizer',
                'profile' => 'nullabl|image|mimes:jpg,jpeg,png|max:500'
            ]);
            
            $userData = $request->only(['name', 'email', 'role','profile']);
            if ($request->hasFile('profile')) {
                if ($user->profile) {
                    Storage::disk('public')->delete('user/' . $user->profile);
                }

                $profilePath = $request->file('profile')->store('user', 'public');
                $userData['profile'] = basename($profilePath);
            }

            $user->update($userData);

            return (new UserResource(true, 'User Updated Successfully',$user,200))->response();
        } catch (ValidationException $e) {
            return (new UserResource(false, 'Validation Error', $e->errors(), 422))->response();        
        } catch (Exception $e) {
            return (new UserResource(false,'An error occurred',$e->getMessage(),500))->response();
        }
        
    }

    public function destroy(User $user)
    {
        try{
            if ($user->profile) {
                Storage::disk('public')->delete('user/' . $user->profile);
            }
                $user->delete();
                return new UserResource(true, 'User Deleted Successfully');
            }
        catch(Exception $e){
            return (new UserResource(false,'An error occurred',$e->getMessage(),500))->response();
        }
    }

    public function register(Request $request)
    {
        try {
    
            $request->validate([
                'name' => "required|string",
                'email' => "required|email:rfc,dns|unique:users,email",
                'password' => "required|min:8",
                'role' => 'nullable|in:participant',
                'profile' => 'required|image|mimes:jpeg,png,jpg|max:500',
            ]);

            $userData = $request->only(['name', 'email']);
            $userData['role'] = $request->role ?? 'participant';
            $userData['password'] = Hash::make($request->password);
            $userData['profile'] = basename($request->file('profile')->store('user', 'public'));

            $user = User::create($userData);

            return (new UserResource(true, 'User Created Successfully',$user,201))->response();
        } catch (ValidationException $e) {
            return (new UserResource(false, 'Validation Error', $e->errors(), 422))->response();        
        } catch (Exception $e) {
            return (new UserResource(false,'An error occurred',$e->getMessage(),500))->response();
        }
    }

    public function resetpassword(Request $request,User $user){
        try{
            $request->validate([
                'old_password' => "required|string",
                'current_password' => "required|min:8",
                'confirm_password' => "required|min:8|same:current_password",
            ]);

            if (!Hash::check($request->old_password, $user->password)) {
                return (new UserResource(false, 'Old password is incorrect', [
                'old_password' => ['The provided old password is incorrect.']
            ], 422))->response();
            }
            $user->password = Hash::make($request->current_password);

            $user->save();
            return (new UserResource(true, 'User password  update Successfully',[],200))->response();
        } catch (ValidationException $e) {
            return (new UserResource(false, 'Validation Error', $e->errors(), 422))->response();        
        } catch (Exception $e) {
            return (new UserResource(false,'An error occurred',$e->getMessage(),500))->response();
        }
    }

    public function login(Request $request)
    {
        // $credentials = $request->only('email', 'password');

        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email is not registered',
                'data'=>[]
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        try {
            // Coba membuat token JWT
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create token',
            ], 500);
        }

        // Jika berhasil, kembalikan token
        return response()->json([
            'success' => true,
            'token' => $token,
            'data' =>  $user->only(['id', 'name', 'email', 'role']),
        ], 200);
    }

    public function refresh()
{
    try {
        $newToken = JWTAuth::refresh(JWTAuth::getToken());
        return response()->json([
            'success' => true,
            'token' => $newToken,
            'data'=>[]
        ], 200);
    } catch (JWTException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Could not refresh token',
            'data'=>$e->getMessage()
        ], 500);
    }
}


}
