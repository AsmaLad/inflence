<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//AUTH
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:api')->group(function(){
    Route::post('logout',[AuthController::class,'logout']);
});

//PROFILE
Route::middleware('auth:api')->group(function(){
    Route::put('profile', [ProfileController::class, 'updateProfile']);
    Route::get('profile', [ProfileController::class, 'getProfile']);
});

//EVENTS
Route::middleware('auth:api')->group(function () {
    // Route::apiResource('events', 'EventsController');
    Route::post('add-event',[EventsController::class,'store']);

});
