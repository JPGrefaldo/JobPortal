<?php

Route::prefix('/producer/projects')->group(function () {
    Route::get('/', [\App\Http\Controllers\Producer\ProjectsController::class, 'index'])
        ->name('producer.projects');

    Route::post('/', [\App\Http\Controllers\Producer\ProjectsController::class, 'store'])
        ->name('producer.projects.store');

    Route::get('/create', [\App\Http\Controllers\Producer\ProjectsController::class, 'create'])
        ->name('producer.projects.create');
    
    Route::put('/{project}', [\App\Http\Controllers\Producer\ProjectsController::class, 'update'])
        ->name('producer.project.update');
});

Route::prefix('/producer/jobs')->group(function () {
    Route::post('/', [\App\Http\Controllers\Producer\ProjectJobsController::class, 'store'])
        ->name('producer.jobs');
    Route::put('/{job}', [\App\Http\Controllers\Producer\ProjectJobsController::class, 'update'])
        ->name('producer.job.update');
});

Route::group(['prefix' => 'messages'], function () {
    // TODO: defer to common route for both crew and admin
    Route::post('/{project}', [
        \App\Http\Controllers\Producer\MessagesController::class,
        'store',
    ])->name('producer.messages.store');

    // TODO: defer to common route for both crew and admin
    Route::put('/producer/projects/{project}/messages/{message}', [
        \App\Http\Controllers\Producer\MessagesController::class,
        'update',
    ])->name('producer.messages.update');
});
