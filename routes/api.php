<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;

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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    //PROFILE
    Route::put('profile/{id}', [ProfileController::class, 'updateProfile']);
    Route::get('profile', [ProfileController::class, 'getProfile']);
    Route::get('users', [ProfileController::class, 'getAllUsers']);
    Route::get('clients', [ProfileController::class, 'getAllClients']);
    Route::get('contributeurs', [ProfileController::class, 'getAllContributeurs']);

    //EVENTS
    Route::post('add-event/{contributeurId}/{clientId}', [EventsController::class, 'store']);
    Route::get('events', [EventsController::class, 'index']);
    Route::get('event/{id}', [EventsController::class, 'show']);
    Route::put('event/{id}', [EventsController::class, 'update']);
    Route::delete('event/{id}', [EventsController::class, 'destroy']);

    //COMMENTS
    Route::post('comments', [CommentsController::class, 'store']);
    Route::get('comments', [CommentsController::class, 'index']);
    Route::get('comments/{id}', [CommentsController::class, 'show']);
    Route::put('comments/{id}', [CommentsController::class, 'update']);
    Route::delete('comments/{id}', [CommentsController::class, 'destroy']);

    //TASKS
    Route::post('tasks', [TasksController::class, 'store']);
    Route::get('tasks', [TasksController::class, 'index']);
    Route::get('tasks/{id}', [TasksController::class, 'show']);
    Route::put('tasks/{id}', [TasksController::class, 'update']);
    Route::delete('tasks/{id}', [TasksController::class, 'destroy']);

    //TABLE
    Route::get('users-events', [EventsController::class, 'getEventsWithUsers']);
    Route::get('user/{id}', [UserController::class, 'getUserById']);
    Route::get('all-users', [UserController::class, 'getAllUsers']);

    //FEEDBACK
    Route::get('/feedbacks', [FeedbackController::class, 'index']);
    Route::get('/feedbacks/create', [FeedbackController::class, 'create']);
    Route::post('/feedbacks', [FeedbackController::class, 'store']);
    Route::get('/feedbacks/{id}', [FeedbackController::class, 'show']);
    Route::get('/feedbacks/{id}/edit', [FeedbackController::class, 'edit']);
    Route::put('/feedbacks/{id}', [FeedbackController::class, 'update']);
    Route::delete('/feedbacks/{id}', [FeedbackController::class, 'destroy']);
});
