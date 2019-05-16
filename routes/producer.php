<?php

Route::prefix('/producer/projects')->group(function () {
    Route::get('/', [\App\Http\Controllers\Producer\ProjectController::class, 'index'])
        ->name('producer.projects');

    Route::post('/', [\App\Http\Controllers\Producer\ProjectController::class, 'store'])
        ->name('producer.projects.store');

    Route::get('/create', [\App\Http\Controllers\Producer\ProjectController::class, 'create'])
        ->name('producer.projects.create');
    Route::get('/edit/{project}', [\App\Http\Controllers\Producer\ProjectController::class, 'edit'])
        ->name('producer.projects.edit');
    Route::put('/{project}', [\App\Http\Controllers\Producer\ProjectController::class, 'update'])
        ->name('producer.project.update');
});

Route::prefix('/producer/jobs')->group(function () {
    Route::post('/', [\App\Http\Controllers\Producer\ProjectJobController::class, 'store'])
        ->name('producer.jobs');
    Route::put('/{job}', [\App\Http\Controllers\Producer\ProjectJobController::class, 'update'])
        ->name('producer.job.update');
});

Route::group(['prefix' => 'messages'], function () {
    // TODO: defer to common route for both crew and admin
    Route::post('/{project}', [
        \App\Http\Controllers\Producer\MessageController::class,
        'store',
    ])->name('producer.messages.store');

    // TODO: defer to common route for both crew and admin
    Route::put('/producer/projects/{project}/messages/{message}', [
        \App\Http\Controllers\Producer\MessageController::class,
        'update',
    ])->name('producer.messages.update');
});
