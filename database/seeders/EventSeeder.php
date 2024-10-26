<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run()
    {
        Event::insert([
            [
                'title' => 'Tech Conference 2024',
                'description' => 'A conference discussing the latest trends in technology.',
                'location' => 'Convention Center, Jakarta',
                'date' => '2024-05-15',
                'time' => '09:00:00',
            ],
            [
                'title' => 'Workshop on Web Development',
                'description' => 'Hands-on workshop focusing on modern web technologies.',
                'location' => 'Community Hall, Bandung',
                'date' => '2024-06-20',
                'time' => '10:00:00',
            ],
            [
                'title' => 'Annual Science Fair',
                'description' => 'Showcasing innovative projects from local students.',
                'location' => 'School Auditorium, Surabaya',
                'date' => '2024-07-10',
                'time' => '08:30:00',
            ],
            [
                'title' => 'Startup Pitch Day',
                'description' => 'Presenting new startup ideas to investors.',
                'location' => 'Startup Hub, Yogyakarta',
                'date' => '2024-08-05',
                'time' => '14:00:00',
            ],
            [
                'title' => 'Health & Wellness Expo',
                'description' => 'Exploring health products and wellness solutions.',
                'location' => 'Expo Center, Medan',
                'date' => '2024-09-25',
                'time' => '09:00:00',
            ],
        ]);
    }
}
