<?php

use App\Http\Middleware\AuthorizeRoles;
use App\Models\Role;

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

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [
        \App\Http\Controllers\API\UserController::class,
        'show',
    ]);

    Route::get('/crew/departments', [
        \App\Http\Controllers\API\Crew\DepartmentsController::class,
        'index'
    ])->name('crew.departments.index');

    Route::get('/crew/projects', [
        \App\Http\Controllers\API\Crew\ProjectsController::class,
        'index',
    ])->name('crew.projects.index');

    Route::get('/crew/positions', [
        \App\Http\Controllers\API\Crew\PositionsController::class,
        'index'
    ])->name('crew.positions.index');

    Route::get('/crew/sites', [
        \App\Http\Controllers\API\Crew\SitesController::class,
        'index'
    ])->name('crew.sites.index');

    Route::get('/producer/projects', [
        \App\Http\Controllers\API\Producer\ProjectsController::class,
        'index',
    ])->name('producer.projects.index');

    Route::post('/producer/projects', [
        \App\Http\Controllers\API\Producer\ProjectsController::class,
        'store'
    ])->name('producer.project.store');

    Route::get('/producer/project/type', [
        \App\Http\Controllers\API\Producer\ProjectTypes::class,
        'index'
    ])->name('producer.project.type');

    Route::get('/threads/{thread}/messages', [
        \App\Http\Controllers\MessagesController::class,
        'index',
    ])->middleware('role:Producer|Crew')->name('messages.index');

    Route::post('/threads/{thread}/messages', [
        \App\Http\Controllers\MessagesController::class,
        'store',
    ])->middleware('role:Producer|Crew')->name('messages.store');

    Route::get('/producer/projects/{project}/threads', [
        \App\Http\Controllers\Producer\ThreadsController::class,
        'index',
    ])->name('producer.threads.index');

    Route::post('/threads/{thread}/participants', [
        \App\Http\Controllers\API\ParticipantsController::class,
        'search',
    ])->middleware('role:Producer|Crew')->name('threads.search.participants');

    Route::get('/crew/projects/{project}/threads', [
        \App\Http\Controllers\Crew\ThreadsController::class,
        'index',
    ])->name('crew.threads.index');
});
