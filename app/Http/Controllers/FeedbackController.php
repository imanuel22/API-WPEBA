<?php
namespace App\Http\Controllers;

use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::all();
        return new FeedbackResource(true, 'List of Feedbacks', $feedbacks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $feedback = Feedback::create($request->all());

        return new FeedbackResource(true, 'Feedback Created Successfully', $feedback);
    }

    public function show(Feedback $feedback)
    {
        return new FeedbackResource(true, 'Feedback Details', $feedback);
    }

    public function update(Request $request, Feedback $feedback)
    {
        $request->validate([
            'comment' => 'string',
            'rating' => 'integer|min:1|max:5'
        ]);

        $feedback->update($request->all());

        return new FeedbackResource(true, 'Feedback Updated Successfully', $feedback);
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return new FeedbackResource(true, 'Feedback Deleted Successfully', null);
    }
}
