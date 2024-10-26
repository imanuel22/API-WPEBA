<?php
namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        return Feedback::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
            'feedback_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $feedback = Feedback::create($request->all());

        return response()->json($feedback, 201);
    }

    public function show(Feedback $feedback)
    {
        return response()->json($feedback);
    }

    public function update(Request $request, Feedback $feedback)
    {
        $request->validate([
            'feedback_text' => 'string',
            'rating' => 'integer|min:1|max:5',
        ]);

        $feedback->update($request->all());

        return response()->json($feedback);
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return response()->noContent();
    }
}
