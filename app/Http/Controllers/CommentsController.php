<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return response()->json(['data' => $comments]);
    }

    public function store(Request $request)
    {
        $comment = Comment::create($request->all());
        return response()->json(['data' => $comment], 201);
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
