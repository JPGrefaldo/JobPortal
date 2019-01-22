<?php

use App\Http\Middleware\AuthorizeRoles;
use App\Models\Role;
use Illuminate\Http\Request;

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
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::get('/crew/projects', [
        \App\Http\Controllers\Crew\ProjectsController::class,
        'index'
    ])->name('crew.projects.index');

    Route::get('/producer/projects', [
        \App\Http\Controllers\Producer\ProjectsController::class,
        'index'
    ])->name('producer.projects.index');
});
