<?php

use App\Http\Controllers\AttachmentsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IdeaIssueController;
use App\Http\Controllers\IdeasController;
use App\Http\Controllers\IdeaTagsController;
use App\Http\Controllers\LeadAssignController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\LeadsSearchController;
use App\Http\Controllers\LeadStatusController;
use App\Http\Controllers\LeadTagsController;
use App\Http\Controllers\LeadTasksController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RequesterCommentsController;
use App\Http\Controllers\RequestersController;
use App\Http\Controllers\RequesterTicketsController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TeamAgentsController;
use App\Http\Controllers\TeamMembershipController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\TicketsAssignController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\TicketsEscalateController;
use App\Http\Controllers\TicketsIdeaController;
use App\Http\Controllers\TicketsIssueController;
use App\Http\Controllers\TicketsMergeController;
use App\Http\Controllers\TicketsSearchController;
use App\Http\Controllers\TicketsTagsController;
use App\Http\Controllers\TicketTypesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::prefix('requester')->name('requester.')->group(function () {
    Route::controller(RequesterTicketsController::class)->name('tickets.')->group(function () {
        Route::get('tickets/{token}', 'show')->name('show');
        Route::get('tickets/{token}/rate', 'rate')->name('rate');
    });
    Route::post('tickets/{token}/comments', [RequesterCommentsController::class, 'store'])->name('comments.store');
});

Route::post('webhook/bitbucket', [WebhookController::class, 'store']);

Route::middleware(['auth', 'userLocale'])->group(function () {
    Route::controller(ProfileController::class)->name('profile.')->group(function () {
        Route::get('profile', 'show')->name('show');
        Route::put('profile', 'update')->name('update');
        Route::post('password', 'password')->name('password');
    });

    Route::get('tickets/merge', [TicketsMergeController::class, 'index'])->name('tickets.merge.index');
    //Route::post('tickets/merge', [TicketsMergeController::class, 'store'])->name('tickets.merge.store');
    Route::get('tickets/search/{text}', [TicketsSearchController::class, 'index'])->name('tickets.search');
    Route::resource('tickets', TicketsController::class, ['except' => ['edit', 'destroy']]);
    Route::post('tickets/{ticket}/assign', [TicketsAssignController::class, 'store'])->name('tickets.assign');
    Route::post('tickets/{ticket}/comments', [CommentsController::class, 'store'])->name('comments.store');
    Route::resource('tickets/{ticket}/tags', TicketsTagsController::class, ['only' => ['store', 'destroy'], 'as' => 'tickets']);
    Route::post('tickets/{ticket}/reopen', [TicketsController::class, 'reopen'])->name('tickets.reopen');

    Route::post('tickets/{ticket}/escalate', [TicketsEscalateController::class, 'store'])->name('tickets.escalate.store');
    Route::delete('tickets/{ticket}/escalate', [TicketsEscalateController::class, 'destroy'])->name('tickets.escalate.destroy');

    Route::post('tickets/{ticket}/issue', [TicketsIssueController::class, 'store'])->name('tickets.issue.store');
    Route::post('tickets/{ticket}/idea', [TicketsIdeaController::class, 'store'])->name('tickets.idea.store');

    Route::get('requesters', [RequestersController::class, 'index'])->name('requesters.index');

    Route::resource('leads', LeadsController::class);
    Route::get('leads/search/{text}', [LeadsSearchController::class, 'index'])->name('leads.search');
    Route::post('leads/{lead}/assign', [LeadAssignController::class, 'store'])->name('leads.assign');
    Route::post('leads/{lead}/status', [LeadStatusController::class, 'store'])->name('leads.status.store');
    Route::resource('leads/{lead}/tags', LeadTagsController::class, ['only' => ['store', 'destroy'], 'as' => 'leads']);
    Route::resource('leads/{lead}/tasks', LeadTasksController::class, ['only' => ['index', 'store', 'update', 'destroy'], 'as' => 'leads']);

    Route::get('attachments/{filename}', [AttachmentsController::class, 'show'])->name('attachments');
    Route::resource('tasks', TasksController::class, ['only' => ['index', 'update', 'destroy']]);

    Route::resource('teams', TeamsController::class);
    Route::get('teams/{team}/agents', [TeamAgentsController::class, 'index'])->name('teams.agents');
    Route::get('teams/{token}/join', [TeamMembershipController::class, 'index'])->name('membership.index');
    Route::post('teams/{token}/join', [TeamMembershipController::class, 'store'])->name('membership.store');

    Route::middleware('can:see-admin')->group(function () {
        Route::resource('ideas', IdeasController::class);
        Route::get('roadmap', [RoadmapController::class, 'index'])->name('roadmap.index');
        Route::resource('ideas/{idea}/tags', IdeaTagsController::class, ['only' => ['store', 'destroy'], 'as' => 'ideas']);
        Route::post('ideas/{idea}/issue', [IdeaIssueController::class, 'store'])->name('ideas.issue.store');

        Route::resource('users', UsersController::class, ['only' => ['index', 'destroy', 'create']]);
        Route::post('users/store', [UsersController::class, 'store'])->name('user.store');
        Route::get('users/{user}/impersonate', [UsersController::class, 'impersonate'])->name('users.impersonate');
        Route::resource('settings', SettingsController::class, ['only' => ['edit', 'update']]);
        Route::get('ticketTypes', [TicketTypesController::class, 'index'])->name('ticketTypes.index');
    });

    Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('analytics', [ReportsController::class, 'analytics'])->name('reports.analytics');
});
