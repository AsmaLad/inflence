<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return response()->json(['tasks' => $tasks], 200);
    }

    public function store(Request $request)
    {
        $task = Task::create($request->all());

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
