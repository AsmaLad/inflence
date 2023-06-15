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
        // $comments = Comment::with('event')->get();
        // $event=Event::where('uuid',$request->email)->first();
        $comments = Event::with('comments')->get();

        // $responseData = $comments->map(function ($comment) {
        //     return [
        //         'comment' => $comment->comment,
        //         'event_name' => $comment->event->title,
        //     ];
        // });

        return response()->json(['data' => $comments]);
    }

    public function store(Request $request)
{
    $user = Auth::user();
    $events = $user->events[0]->uuid;
    
        $comment = new Comment();
        $comment->comment = $request->input('comment');//comment
        $comment->user_id = $user->uuid; //user_id
        $comment->event_uuid = $events;
        $comment->save();
        // $username = $user->name;
        // return response()->json(['data' => $comment, 'username' => $username], 201);  'data' => $events,
    return response()->json(['message' => 'Comment added successfully'], 201);

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
