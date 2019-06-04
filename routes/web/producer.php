<?php

use App\Http\Controllers\Producer\ProjectController;
Route::get('/producer/projects', [ProjectController::class, 'index'])
    ->name('producer.projects');
Route::post('/producer/projects', [ProjectController::class, 'store'])
    ->name('producer.projects.store');
Route::put('/producer/projects/{project}', [ProjectController::class, 'update'])
    ->name('producer.project.update');
Route::get('/producer/projects/create', [ProjectController::class, 'create'])
    ->name('producer.projects.create');