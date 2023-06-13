<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    // public function updateProfile(Request $request)
    // {
    //     $user = $request->user();

    //     $request->validate([
    //         'name' => 'required',
    //     ]);

    //     $user->name = $request->input('name');
    //     $user->save();

    //     return response()->json(['message' => 'Profile updated successfully']);
    // }

    // public function updateProfile(Request $request)
    // {
    //     // Get the authenticated user
    //     $user = Auth::guard('api')->user();

    //     // Verify that the user is authenticated
    //     if (!$user) {
    //         return response()->json(['message' => 'Unauthenticated.'], 401);
    //     }

    //     // Update the user profile
    //     $user->name = $request->input('name');
    //     $user->email = $request->input('email');
    //     $user->role = $request->input('role');
    //     // Add any other profile fields you want to update
    //     $user->save();

    //     return response()->json(['message' => 'Profile updated successfully.', 'data' => $user]);
    // }

    public function updateProfile($userId, Request $request)
    {
        $user = User::findOrFail($userId);
        $user->update($request->all());
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function getProfile()
    {
        $user = Auth::guard('api')->user();
        return response()->json(['data' => $user]);
    }

    public function getAllUsers()
    {
        $users = User::whereNull('role')->get();
        return response()->json(['message' => 'User updated successfully', 'users' => $users]);
    }
}