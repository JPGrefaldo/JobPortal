<?php

use App\Http\Controllers\Producer\MessageController;
use App\Http\Controllers\Producer\ProjectController;
use App\Http\Controllers\Producer\ProjectJobController;

Route::get('/producer/projects', [ProjectController::class, 'index'])
    ->name('producer.projects');

Route::post('/producer/projects', [ProjectController::class, 'store'])
    ->name('producer.projects.store');

Route::get('/producer/projects/create', [ProjectController::class, 'create'])
    ->name('producer.projects.create');
Route::get('/producer/projects/edit/{project}', [ProjectController::class, 'edit'])
    ->name('producer.projects.edit');
Route::put('/producer/projects/{project}', [ProjectController::class, 'update'])
    ->name('producer.project.update');

Route::post('/producer/jobs', [ProjectJobController::class, 'store'])
    ->name('producer.jobs');
Route::put('/producer/jobs/{job}', [ProjectJobController::class, 'update'])
    ->name('producer.job.update');

// TODO: defer to common route for both crew and admin
Route::post('/messages/{project}', [
    MessageController::class,
    'store',
])->name('producer.messages.store');

// TODO: defer to common route for both crew and admin
Route::put('/messages/producer/projects/{project}/messages/{message}', [
    MessageController::class,
    'update',
])->name('producer.messages.update');
