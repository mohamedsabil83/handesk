<?php

use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\AgentTicketCommentsController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\IdeasController;
use App\Http\Controllers\Api\LeadsController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\TeamLeadsController;
use App\Http\Controllers\Api\TeamTicketsController;
use App\Http\Controllers\Api\TicketAssignController;
use App\Http\Controllers\Api\TicketsController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('apiAuth')->group(function () {
    Route::resource('tickets', TicketsController::class, ['except' => 'destroy']);
    Route::post('tickets/{ticket}/comments', [CommentsController::class, 'store']);
    Route::post('tickets/{ticket}/assign', [TicketAssignController::class, 'store']);
    Route::post('users/create', [UsersController::class, 'store']);
    Route::post('teams', [TeamController::class, 'store']);
    Route::get('users', [UsersController::class, 'index']);
    Route::get('teams/{team}/tickets', [TeamTicketsController::class, 'index']);
    Route::get('teams/{team}/leads', [TeamLeadsController::class, 'index']);

    Route::resource('leads', LeadsController::class, ['only' => 'store']);

    Route::resource('ideas', IdeasController::class, ['only' => ['store', 'index']]);
});

Route::post('agent/login', [AgentController::class, 'login']);

Route::prefix('agent')->middleware('apiAuthAgent')->group(function () {
    Route::resource('tickets', AgentController::class, ['only' => 'index']);
    Route::resource('tickets.comments', AgentTicketCommentsController::class, ['only' => ['index', 'store']]);
});
