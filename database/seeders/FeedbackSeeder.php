<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;

class FeedbackSeeder extends Seeder
{
    public function run()
    {
        Feedback::insert([
            [
                'event_id' => 1,
                'user_id' => 2, 
                'feedback_text' => 'Amazing event! Really enjoyed the sessions.',
                'rating' => 5,
            ],
            [
                'event_id' => 1,
                'user_id' => 3, 
                'feedback_text' => 'Very insightful talks, especially the keynote.',
                'rating' => 4,
            ],
            [
                'event_id' => 2,
                'user_id' => 4, 
                'feedback_text' => 'Great organization, but could improve on time management.',
                'rating' => 3,
            ],
            [
                'event_id' => 3,
                'user_id' => 5, 
                'feedback_text' => 'Loved the networking opportunities!',
                'rating' => 5,
            ],
            [
                'event_id' => 4,
                'user_id' => 2, 
                'feedback_text' => 'The content was relevant, but the pace was too fast.',
                'rating' => 4,
            ],
        ]);
    }
}
