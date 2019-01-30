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
        'show'
    ]);

    Route::get('/crew/projects', [
        \App\Http\Controllers\API\Crew\ProjectsController::class,
        'index'
    ])->name('crew.projects.index');

    Route::get('/producer/projects', [
        \App\Http\Controllers\API\Producer\ProjectsController::class,
        'index'
    ])->name('producer.projects.index');

    Route::get('/producer/projects/{project}/threads', [
        \App\Http\Controllers\Producer\ThreadsController::class,
        'index'
    ])->name('producer.threads.index');

    Route::get('/crew/projects/{project}/threads', [
        \App\Http\Controllers\Crew\ThreadsController::class,
        'index'
    ])->name('crew.threads.index');
});
