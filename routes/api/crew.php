<?php

use App\Http\Controllers\Crew\CrewPositionController;
use App\Http\Controllers\Crew\Endorsements\EndorsementEndorsedController;
use App\Http\Controllers\Crew\Endorsements\EndorsementPositionController;
use App\Http\Controllers\Crew\Endorsements\EndorsementRequestController;

Route::post('/crew/positions/{position}', [CrewPositionController::class, 'store'])
    ->name('crew-position.store');
Route::delete('/crew/positions/{position}/delete', [CrewPositionController::class, 'destroy'])
    ->name('crew-position.delete');
Route::delete('/crew/positions/{position}/resume', [CrewPositionController::class, 'removeResume']);

Route::post('crew/endorsement/positions/{position}', [EndorsementPositionController::class, 'store'])
    ->name('crew.endorsement.position.store');

// TODO: Delete?
Route::get('crew/endorsement/positions/endorsed/{position}', [EndorsementEndorsedController::class, 'index'])
    ->name('crew.endorsement.endorsed');

Route::delete('crew/endorsement/positions/request/{endorsementRequest}', [EndorsementRequestController::class, 'destroy'])
    ->name('crew.endorsement.request.destroy');
