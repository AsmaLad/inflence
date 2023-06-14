<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
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
            $eventData['client_id'] = $clientId;
    
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
}
