<?php
namespace App\Http\Controllers;

use Exception;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResponseSuccessResource;
use App\Http\Resources\ApiResponseErrorResource;
use Illuminate\Validation\ValidationException;

class FeedbackController extends Controller
{
    public function index()
    {
        try {
            $feedbacks = Feedback::with(['user'])->get();
            return (new ApiResponseSuccessResource('List of Feedbacks', $feedbacks))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', ['error' => $e->getMessage()], 500))->response();
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'event_id' => 'required|exists:events,id',
                'comment' => 'required|string',
                'rating' => 'required|integer|min:1|max:5'
            ]);

            $feedback = Feedback::create($request->only(['user_id', 'event_id', 'comment', 'rating']));
            return (new ApiResponseSuccessResource('Feedback Created Successfully', $feedback, 201))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('An error occurred', ['error' => $e->getMessage()], 500))->response();
        }
    }

    public function show($id)
    {
        try {
            $feedback = Feedback::with('user')->findOrFail($id);
            return (new ApiResponseSuccessResource('Feedback Details', $feedback))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Feedback Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'comment' => 'nullable|string',
                'rating' => 'nullable|integer|min:1|max:5'
            ]);

            $feedback = Feedback::findOrFail($id);
            $feedback->update($request->only(['comment', 'rating']));

            return (new ApiResponseSuccessResource('Feedback Updated Successfully', $feedback))->response();
        } catch (ValidationException $e) {
            return (new ApiResponseErrorResource('Validation Error', $e->errors(), 422))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Feedback Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }

    public function destroy($id)
    {
        try {
            $feedback = Feedback::findOrFail($id);
            $feedback->delete();
            return (new ApiResponseSuccessResource('Feedback Deleted Successfully', null))->response();
        } catch (Exception $e) {
            return (new ApiResponseErrorResource('Feedback Not Found', ['error' => $e->getMessage()], 404))->response();
        }
    }
}
