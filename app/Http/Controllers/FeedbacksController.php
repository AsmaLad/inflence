<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FeedbacksController extends Controller
{
    public function index()
    {
        $feedbacks = Event::with('feedbacks')->get();

        return response()->json(['feedbacks' => $feedbacks], 201);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'client') {
            $events = $user->eventsClient;
        }

        $mappedArray = collect($events)->map(function ($item) {
            // Transform the object as per your requirements
            return [
                'event_id' => $item['uuid']
            ];
        });


        $feedbacks = new Feedback();
        $feedbacks->corps = $request->input('corps');
        $feedbacks->user_id = $user->uuid;
        $feedbacks->username = $user->name;
        $feedbacks->event_uuid = $mappedArray[0]['event_id'];
        $feedbacks->save();

        return response()->json(['message' => 'Comment added successfully'], 201);
    }

    public function show($id)
    {
        $feedbacks = Feedback::findOrFail($id);
        return response()->json(['data' => $feedbacks]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $feedbacks = Feedback::findOrFail($id);
        $feedbacks->update($data);

        return response()->json(['data' => $feedbacks]);
    }

    public function destroy($id)
    {
        $feedbacks = Feedback::findOrFail($id);
        $feedbacks->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }

    public function getFeedbackUser()
    {
        $user = Auth::user();

        $feedbacks = Event::with('feedbacks')->get();

        $filteredFeedbacks = $feedbacks->filter(function ($feedback) use ($user) {
            return $feedback->user_id == $user->uuid;
        });

        return response()->json(['feedbacks' => $filteredFeedbacks], 201);
    }
}