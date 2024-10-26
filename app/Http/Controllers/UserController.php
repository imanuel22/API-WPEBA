<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return new UserResource(200, 'List Data User', $user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'profile'=> 'required|image|mimes:jpeg,png,jpg|max:2048',
            'name'=> 'required|string',
            'password'=> 'required|password',
            'email'=> 'required|email',
            'role'=> 'required',
        ]);

        if ($validator->failed()){
            return response()->json($validator->errors(),422);
        };
        
        $profile = $request->file('profile');
        $profile->storeAs('
        user',$profile->hashName());
        $user = User::create([
            'profile'=> $profile->hashName(),
            'name'=> $request->name,
            'password'=> bcrypt($request->password),
            'email'=> $request->email,
            'role'=> $request->role,
        ]);

        return new UserResource(201,'Data User',$user);
    }   

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        return new UserResource(200, 'List Data User', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required|string',
            'email'=> 'required|email',
            'role'=> 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::find($id);
        if ($request->hasFile('profile')) {
            $profile = $request->file('profile');
            $profile->storeAs('
            user', $profile->hashName());

            Storage::delete('
            user/' . basename($user->profile));

            //update post with new image
            $user->update([
                'profile'=> $profile->hashName(),
                'name'=> $request->name,
                'email'=> $request->email,
                'role'=> $request->role,
            ]);
        } else {

            //update post without image
            $user->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'role'=> $request->role,
            ]);
        }

        //return response
        return new UserResource(true, 'Data Post Berhasil Diubah!', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = User::find($id);
        //delete image
        Storage::delete('
        user/'.basename($post->image));

        //delete post
        $post->delete();

        //return response
        return new UserResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}
