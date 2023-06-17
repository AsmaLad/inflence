<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return response()->json(['data' => $events]);
    }

    public function store(Request $request, $contributeurId, $clientId)
    {
        $loggedInUser = Auth::user();

        if ($loggedInUser->role === 'admin') {
            $eventData = $request->all();
            $eventData['contributeur_id'] = $contributeurId;
            $eventData['user_id'] = $clientId;

            $event = Event::create($eventData);

            return response()->json(['data' => $event], 201);
        }
        return response()->json(['message' => 'Only admin users can create events'], 403);

    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json(['data' => $event]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return response()->json(['data' => $event]);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function getEventsWithUsers()
    {
        $events = Event::select('title', 'status', 'progress', 'uuid', 'contributeur_id', 'user_id')->get();
        $arr = [];

        if (is_array($arr) || is_countable($arr)) {
            foreach ($events as $event) {
                $obj = new \stdClass();
                $taskObj = new \stdClass();
                $contributeurId = $event->contributeur_id;
                $clientId = $event->user_id;

                $eventUuid =$event->uuid; 

                $allTasks= Task::all();
                foreach ($allTasks as $task) {
                    $taskObj->tasks = [];

                    if ($task->event_uuid == $eventUuid)
                    {
                        $taskObj->tasks[]=$task;
                    }
                }

                $userContributeurs = User::findOrFail($contributeurId); //contributeur_id
                $userClients = User::find($clientId); //client_id
                $obj->event_data = $event;
                $obj->client = $userClients;
                $obj->contributeur = $userContributeurs;
                $obj->allTasks = $taskObj;
                array_push($arr, $obj);

            }
        }
        return response()->json(['data' => $arr], 200);
    }
}