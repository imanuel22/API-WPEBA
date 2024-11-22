<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::insert([
            [
                'name' => 'Admin User',
                'email' => 'admin1@gmail.com',
                'password' => Hash::make('admin1234'),
                'role' => 'admin',
                'profile'=>'admin.jpg',
                'email_verified_at' => now()
            ]
        ]);
    }
}
