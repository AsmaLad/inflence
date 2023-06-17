<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Event;
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
        // $events = $user->events;

        // $tasks = Task::all();
        $events = Event::all();
        $task = new \stdClass();
        $task = new Task();

        foreach($events as $event) {

            if ($user->role !== 'client' && $event->contributeur_id == $user->uuid) {

                $task->name = $request->input('name');
                // $task->progress = $request->input('progress');
                $task->status = $request->input('status');
                $task->user_id = $user->uuid;
                $task->event_uuid = $event->uuid;
            }
        
        }


                    $task->save();

        // 

        //     $mappedArray = collect($events)->map(function ($item) {
        //         // Transform the object as per your requirements
        //         return [
        //             'event_id' => $item['uuid']
        //         ];
        //     });


        //     // $task
        //     $task->event_uuid = $mappedArray[0]['event_id'];


        // }
        // return response()->json(['message' => 'Only admin and contributeurs can add tasks events'], 403);
        return response()->json(['tasks' =>  [$task]], 201);

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