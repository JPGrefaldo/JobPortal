<?php

use App\Http\Controllers\Producer\MessageController;
use App\Http\Controllers\Producer\ProjectController;
use App\Http\Controllers\Producer\ProjectJobController;

Route::prefix('/producer/projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])
        ->name('producer.projects');

    Route::post('/', [ProjectController::class, 'store'])
        ->name('producer.projects.store');

    Route::get('/create', [ProjectController::class, 'create'])
        ->name('producer.projects.create');
    Route::get('/edit/{project}', [ProjectController::class, 'edit'])
        ->name('producer.projects.edit');
    Route::put('/{project}', [ProjectController::class, 'update'])
        ->name('producer.project.update');
});

Route::prefix('/producer/jobs')->group(function () {
    Route::post('/', [ProjectJobController::class, 'store'])
        ->name('producer.jobs');
    Route::put('/{job}', [ProjectJobController::class, 'update'])
        ->name('producer.job.update');
});

Route::group(['prefix' => 'messages'], function () {
    // TODO: defer to common route for both crew and admin
    Route::post('/{project}', [
        MessageController::class,
        'store',
    ])->name('producer.messages.store');

    // TODO: defer to common route for both crew and admin
    Route::put('/producer/projects/{project}/messages/{message}', [
        MessageController::class,
        'update',
    ])->name('producer.messages.update');
});
