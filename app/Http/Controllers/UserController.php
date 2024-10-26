<?php
namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return new UserResource(true, 'List of Users', $users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,participant,speaker,organizer',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userData = $request->only(['name', 'email', 'role']);
        $userData['password'] = Hash::make($request->password);

        if ($request->hasFile('profile')) {
            $path = $request->file('profile')->store('images/users', 'public');
            $userData['profile'] = $path;
        }

        $user = User::create($userData);

        return new UserResource(true, 'User Created Successfully', $user);
    }

    public function show(User $user)
    {
        $user->image = $user->image ? url('storage/' . $user->image) : null;
        return new UserResource(true, 'User Details', $user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $user->id,
            'role' => 'in:admin,participant,speaker,organizer',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userData = $request->only(['name', 'email', 'role']);

        if ($request->hasFile('profile')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $path = $request->file('profile')->store('images/users', 'public');
            $userData['profile'] = $path;
        }

        $user->update($userData);

        return new UserResource(true, 'User Updated Successfully', $user);
    }

    public function destroy(User $user)
    {
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();

        return new UserResource(true, 'User Deleted Successfully', null);
    }
}
