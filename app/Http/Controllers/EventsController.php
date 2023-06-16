<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
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
        // $events = Event::all();
        $events = Event::select('title', 'status', 'progress')->get();
        $contributeurIds = Event::pluck('contributeur_id')->all();
        $clientIds = Event::pluck('user_id')->all();
        
        $userContributeurs = User::whereIn('uuid', $contributeurIds)->get();
        $userClients = User::whereIn('uuid', $clientIds)->get();
        
        $data = $events->map(function ($event) use ($userContributeurs, $userClients) {
            $userNameContributeur = $userContributeurs->where('contributeur_id', $event->contributeur_id)->pluck('name')->first();
            $userNameClient = $userClients->where('user_id', $event->user_id)->pluck('name')->first();
        
            return [
                'event' => $event,
                'userNameClient' => $userNameClient,
                'userNameContributeur' => $userNameContributeur,
            ];

        });
        return response()->json(['events' => $data], 200);
        
        // return response()->json(['events' => $userClients], 200);
    }
}
