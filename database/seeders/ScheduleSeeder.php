<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        Schedule::insert([
            [
                'event_id' => 1,
                'session_name' => 'Opening Ceremony',
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
                'description' => 'Inaugural speech and welcome remarks.',
            ],
            [
                'event_id' => 1,
                'session_name' => 'Keynote Speech',
                'start_time' => '10:15:00',
                'end_time' => '11:00:00',
                'description' => 'Insights from industry leaders.',
            ],
            [
                'event_id' => 2,
                'session_name' => 'Workshop: Building APIs',
                'start_time' => '11:30:00',
                'end_time' => '13:00:00',
                'description' => 'Hands-on workshop on API development.',
            ],
            [
                'event_id' => 2,
                'session_name' => 'Networking Lunch',
                'start_time' => '13:00:00',
                'end_time' => '14:00:00',
                'description' => 'Lunch and networking opportunity.',
            ],
            [
                'event_id' => 3,
                'session_name' => 'Panel Discussion',
                'start_time' => '14:15:00',
                'end_time' => '15:30:00',
                'description' => 'Discussion on future trends in technology.',
            ],
        ]);
    }
}
