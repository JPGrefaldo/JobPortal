<?php

use App\Http\Controllers\Producer\ProjectController;

Route::post('/producer/projects', [ProjectController::class, 'store'])
    ->name('producer.projects.store');
Route::put('/producer/projects/{project}', [ProjectController::class, 'update'])
    ->name('producer.project.update');
