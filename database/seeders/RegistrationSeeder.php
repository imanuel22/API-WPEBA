<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Registration;

class RegistrationSeeder extends Seeder
{
    public function run()
    {
        Registration::insert([
            [
                'user_id' => 2, 
                'event_id' => 1, 
                'registration_date' => now(),
                'status' => 'confirmed',
                'payment_status' => 'paid',
            ],
            [
                'user_id' => 3, 
                'event_id' => 1, 
                'registration_date' => now(),
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ],
            [
                'user_id' => 4, 
                'event_id' => 2, 
                'registration_date' => now(),
                'status' => 'confirmed',
                'payment_status' => 'paid',
            ],
            [
                'user_id' => 5, 
                'event_id' => 3, 
                'registration_date' => now(),
                'status' => 'cancelled',
                'payment_status' => 'unpaid',
            ],
            [
                'user_id' => 2, 
                'event_id' => 4, 
                'registration_date' => now(),
                'status' => 'pending',
                'payment_status' => 'unpaid',
            ],
        ]);
    }
}
