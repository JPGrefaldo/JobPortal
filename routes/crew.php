<?php

use App\Http\Controllers\Crew\CrewPositionController;
use App\Http\Controllers\Crew\CrewProfileController;
use App\Http\Controllers\Crew\Endorsements\EndorsementEndorsedController;
use App\Http\Controllers\Crew\Endorsements\EndorsementPositionController;
use App\Http\Controllers\Crew\Endorsements\EndorsementRequestController;
use App\Http\Controllers\Crew\MessageController;
use App\Http\Controllers\Crew\ProjectJobController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\Crew\CrewPositionResumeController;
use App\Http\Controllers\Crew\CrewPositionReelController;

Route::get('crew/endorsement', [EndorsementPositionController::class, 'index'])
    ->name('crew.endorsement.index');

Route::post('crew/endorsement/positions/{position}', [EndorsementPositionController::class, 'store'])
    ->name('crew.endorsement.position.store');
Route::get('crew/endorsement/positions/{position}', [EndorsementPositionController::class, 'show'])
    ->name('crew.endorsement.position.show');

// TODO: Delete?
Route::get('crew/endorsement/positions/endorsed/{position}', [EndorsementEndorsedController::class, 'index'])
    ->name('crew.endorsement.endorsed');

Route::delete('crew/endorsement/positions/request/{endorsementRequest}', [EndorsementRequestController::class, 'destroy'])
    ->name('crew.endorsement.request.destroy');

Route::get('crew/projects/job/{projectJob}', [ProjectJobController::class, 'show'])
      ->name('crew.project.job');
Route::get('crew/jobs/{job}', [SubmissionController::class, 'checkSubmission'])
    ->name('crew.jobs.show');
Route::post('crew/jobs/{job}', [SubmissionController::class, 'store'])
    ->name('crew.jobs.store');

// TODO: defer to common route for both crew and admin
Route::post('/crew/messages', [MessageController::class, 'store'])
    ->name('crew.messages.store');

Route::get('/crew/profile', [CrewProfileController::class, 'index'])
    ->name('crew.profile.index');
Route::get('crew/profile/create', [CrewProfileController::class, 'create'])
    ->name('crew.profile.create');
Route::post('', [CrewProfileController::class, 'store'])
    ->name('crew.profile.store');
Route::get('crew/profile/edit', [CrewProfileController::class, 'edit'])
    ->name('crew.profile.edit');
Route::put('crew/profile/update', [CrewProfileController::class, 'update'])
    ->name('crew.profile.update');

Route::post('/crew/photos', [CrewProfileController::class, 'storePhoto']);

Route::get('/crew/positions/list', [CrewPositionController::class, 'getPositionList'])
    ->name('crew-positions-list');
Route::get('/crew/positions/{position}/show', [CrewPositionController::class, 'getPositionData']);
Route::post('/crew/positions/{position}', [CrewPositionController::class, 'store'])
    ->name('crew-position.store');
Route::post('/crew/positions/{position}/update', [CrewPositionController::class, 'update'])
    ->name('crew-position.update');
Route::delete('/crew/positions/{position}/resume', [CrewPositionResumeController::class, 'destroy'])
    ->name('crew-position.delete-resume');
Route::delete('/crew/positions/{position}/reel', [CrewPositionReelController::class, 'destroy'])
    ->name('crew-position.delete-reel');
Route::delete('/crew/positions/{position}/gear', [CrewPositionReelController::class, 'destroy'])
    ->name('crew-position.delete-gear');
Route::delete('/crew/positions/{position}', [CrewPositionController::class, 'destroy'])
    ->name('crew-position.delete');
