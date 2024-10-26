<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,participant,speaker,organizer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userData = $request->only(['name', 'email', 'role']);
        $userData['password'] = Hash::make($request->password);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/users', 'public');
            $userData['image'] = $path;
        }

        $user = User::create($userData);

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        $user->image = $user->image ? url('storage/' . $user->image) : null;
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $user->id,
            'role' => 'in:admin,participant,speaker,organizer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userData = $request->only(['name', 'email', 'role']);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $path = $request->file('image')->store('images/users', 'public');
            $userData['image'] = $path;
        }

        $user->update($userData);

        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();

        return response()->noContent();
    }
}
