<?php

use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\Producer\ProjectJobController;
use App\Http\Controllers\Crew\CrewPositionController;
use App\Http\Controllers\Crew\CrewPositionGearController;
use App\Http\Controllers\Crew\CrewPositionReelController;
use App\Http\Controllers\Crew\CrewPositionResumeController;
use App\Http\Controllers\Crew\CrewProfileController;
use App\Http\Controllers\Crew\CrewPhotoController;
use App\Http\Controllers\SubmissionController;

Route::post('', [CrewProfileController::class, 'store'])->name('crew.profile.store');
Route::put('crew/profile/update', [CrewProfileController::class, 'update'])->name('crew.profile.update');
Route::post('/crew/photos', [CrewProfileController::class, 'storePhoto']);

Route::delete('/crew/photos/{crew}', [CrewPhotoController::class, 'destroy'])->name('crew.photo.destroy');

Route::get('crew/positions/list', [CrewPositionController::class, 'getPositionList'])->name('crew-positions-list');
Route::post('/crew/positions/{position}', [CrewPositionController::class, 'store'])->name('crew-position.store');
Route::get('/crew/positions/{position}', [CrewPositionController::class, 'show'])->name('crew-positions.show');
Route::put('/crew/positions/{position}', [CrewPositionController::class, 'update'])->name('crew-position.update');
Route::delete('/crew/positions/{position}', [CrewPositionController::class, 'destroy'])->name('crew-position.delete');

Route::delete('/crew/positions/{position}/gear', [CrewPositionGearController::class, 'destroy'])->name('crew-position.delete-gear');
Route::delete('/crew/positions/{position}/gear-photo', [CrewPositionGearController::class, 'removePhoto'])->name('crew-position.delete-gear-photo');

Route::delete('/crew/positions/{position}/reel', [CrewPositionReelController::class, 'destroy'])->name('crew-position.delete-reel');

Route::delete('/crew/positions/{position}/resume', [CrewPositionResumeController::class, 'destroy'])->name('crew-position.delete-resume');

// TODO: defer to common route for both crew and admin
Route::post('/crew/messages', [MessageController::class, 'store'])->name('crew.messages.store');

Route::get('crew/projects/job/{projectJob}', [ProjectJobController::class, 'show'])->name('crew.project.job');

Route::get('crew/jobs', [CrewPositionController::class, 'jobs'])->name('crew.jobs');

Route::post('crew/jobs/{job}', [SubmissionController::class, 'store'])->name('crew.jobs.store');
Route::get('crew/jobs/{job}', [SubmissionController::class, 'checkSubmission'])->name('crew.jobs.show');
