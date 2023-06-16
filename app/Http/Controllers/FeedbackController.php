<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::all();

        return response()->json(['feedbacks' => $feedbacks], 201);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Feedback::create($data);

        return response()->json(['message' => 'Comment added successfully'], 201);
    }

    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        return response()->json(['data' => $feedback]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $feedback = Feedback::findOrFail($id);
        $feedback->update($data);

        return response()->json(['data' => $feedback]);
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
