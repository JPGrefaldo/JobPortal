<?php

use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\ParticipantController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
| You can add role specific middlewares through:
| * Single, Route::middleware(AuthorizeRoles::parameterize(Role::CREW))
| * Multiple, Route::middleware(AuthorizeRoles::parameterize(Role::CREW, Role::PRODUCER))
*/
// TODO: defer to common route for both crew and admin
Route::post('/messages/{project}', [MessageController::class, 'store'])
    ->name('producer.messages.store');
// TODO: defer to common route for both crew and admin
Route::put('/messages/producer/projects/{project}/messages/{message}', [MessageController::class, 'update'])
    ->name('producer.messages.update');

// web

Route::middleware('auth:api')->group(function () {
    Route::post('/messenger/projects/{project}/messages', [
        MessageController::class,
        'store',
    ])->middleware('role:Producer|Crew')->name('messenger.project.messages.store');

    Route::get('/messenger/threads/{thread}/messages', [
        MessageController::class,
        'index',
    ])->middleware('role:Producer|Crew')->name('messenger.threads.messages.index');

    Route::put('/messenger/threads/{thread}/messages', [
        MessageController::class,
        'update',
    ])->middleware('role:Producer|Crew')->name('messenger.threads.messages.update');

    Route::post('/messenger/threads/{thread}/search', [
        ParticipantController::class,
        'search',
    ])->middleware('role:Producer|Crew')->name('threads.index.search');

    Route::get('/sites', [
        SiteController::class,
        'index',
    ])->name('sites.index');

    Route::get('/user', [
        UserController::class,
        'show',
    ]);
});
