<?php

use App\Http\Controllers\Crew\CrewPositionController;
use App\Http\Controllers\Crew\CrewProfileController;
use App\Http\Controllers\Crew\Endorsements\EndorsementEndorsedController;
use App\Http\Controllers\Crew\Endorsements\EndorsementRequestController;
use App\Http\Controllers\Crew\MessageController;
use App\Http\Controllers\Crew\ProjectJobController;

  
Route::get('crew/projects/job/{projectJob}', [ProjectJobController::class, 'show'])
      ->name('crew.project.job');

// TODO: defer to common route for both crew and admin
Route::post('/crew/messages', [MessageController::class, 'store'])
    ->name('crew.messages.store');


Route::post('', [CrewProfileController::class, 'store'])
    ->name('crew.profile.store');
Route::put('crew/profile/update', [CrewProfileController::class, 'update'])
    ->name('crew.profile.update');

Route::post('/crew/photos', [CrewProfileController::class, 'storePhoto']);

Route::get('/crew/positions/list', [CrewPositionController::class, 'getPositionList'])
    ->name('crew-positions-list');
Route::get('/crew/positions/{position}/show', [CrewPositionController::class, 'getPositionData']);
Route::get('/crew/positions/{position}/reel', [CrewPositionController::class, 'removeReel']);
