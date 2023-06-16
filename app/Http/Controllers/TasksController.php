<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $tasks = Task::where('user_id', $userId)->get();

        return response()->json(['tasks' => $tasks], 200);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $events = $user->events;
        dd($user);

        // if ($user->role === 'admin' || $user->role === 'contributeur') {

            $mappedArray = collect($events)->map(function ($item) {
                // Transform the object as per your requirements
                return [
                    'event_id' => $item['uuid']
                ];
            });

            // $task = Task::create($request->all());
            $task = new Task();

            $task->name = $request->input('name');
            // $task->progress = $request->input('progress');
            $task->status = $request->input('status');
            $task->user_id = $user->uuid; //user_id
            $task->event_uuid = $mappedArray[0]['event_id'];

            $task->save();

        // }
        // return response()->json(['message' => 'Only admin and contributeurs can add tasks events'], 403);
        return response()->json(['task' => $task], 201);

    }

    public function show($id)
    {
        $task = Task::findOrFail($id);

        return response()->json(['task' => $task], 200);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());

        return response()->json(['task' => $task], 200);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully'], 200);
    }
}