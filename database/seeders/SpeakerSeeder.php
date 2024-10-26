<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Speaker;

class SpeakerSeeder extends Seeder
{
    public function run()
    {
        Speaker::insert([
            [
                'event_id' => 1,
                'name' => 'Alice Brown',
                'topic' => 'The Future of Technology',
            ],
            [
                'event_id' => 1,
                'name' => 'David Wilson',
                'topic' => 'Healthcare Innovations',
            ],
            [
                'event_id' => 2,
                'name' => 'Emma Johnson',
                'topic' => 'Startup Growth Strategies',
            ],
            [
                'event_id' => 3,
                'name' => 'James Lee',
                'topic' => 'Artificial Intelligence in Business',
            ],
            [
                'event_id' => 4,
                'name' => 'Sophia White',
                'topic' => 'Sustainable Practices in Environmental Science',
            ],
        ]);
    }
}
