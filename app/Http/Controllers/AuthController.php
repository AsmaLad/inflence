<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|unique:users|max:255',
            'password'=>'required|min:6'
        ]);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        $token=$user->createToken('auth_token')->accessToken;

        // return response([
        //     'token'=>$token
        // ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user]);


    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        $user=User::where('email',$request->email)->first();

        if(!$user|| !Hash::check($request->password,$user->password)){
            return response([
                'message'=>'The provided credentials are incorrect'
            ]);
        }

        $token=$user->createToken('auth_token')->accessToken;

        return response([
            'data'=> $user,
            'token'=>$token
        ]);


        
    }

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
    

    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response([
            'message'=>'Logged out sucesfully'
        ], 200);
    }
}
