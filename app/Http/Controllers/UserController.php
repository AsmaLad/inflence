<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsersWithEvents()
    {
        $users = User::whereIn('role', ['client', 'contributeur'])
            ->whereHas('events')
            ->with(['events' => function ($query) {
                $query->select('event_name', 'status_event', 'event_progress', 'user_id');
            }])
            ->get(['uuid', 'name']);

        return response()->json(['users' => $users], 200);
    }
}
