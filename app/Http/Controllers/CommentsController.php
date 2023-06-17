<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

class CommentsController extends Controller
{
    public function index()
    {
        $comments = Event::with('comments')->get();



        // $userId = Auth::id();

        // Retrieve the comments belonging to the authenticated user
// $comments = Comment::whereHas('event', function ($query) use ($userId) {
// echo($query);

        //     $query->where('user_id', $userId);
// })->get();


        return response()->json(['data' => $comments]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'client') {
            $events = $user->eventsClient;
        } elseif ($user->role === 'contributeur') {
            $events = $user->eventsContributeur;
        }

        $mappedArray = collect($events)->map(function ($item) {
            // Transform the object as per your requirements
            return [
                'event_id' => $item['uuid']
            ];
        });

        $comment = new Comment();
        $comment->comment = $request->input('comment'); //comment
        $comment->user_id = $user->uuid; //user_id
        $comment->username = $user->name; //user_id
        $comment->event_uuid = $mappedArray[0]['event_id'];
        $comment->save();
        return response()->json(['message' => 'Comment added successfully', 'data' => $comment,], 201);

    }

    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        return response()->json(['data' => $comment]);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update($request->all());
        return response()->json(['data' => $comment]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }
}