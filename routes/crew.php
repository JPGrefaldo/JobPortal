<?php

use App\Http\Controllers\Crew\CrewPositionController;
use App\Http\Controllers\Crew\CrewProfileController;
use App\Http\Controllers\Crew\Endorsements\EndorsementEndorsedController;
use App\Http\Controllers\Crew\Endorsements\EndorsementPositionController;
use App\Http\Controllers\Crew\Endorsements\EndorsementRequestController;
use App\Http\Controllers\Crew\MessageController;
use App\Http\Controllers\Crew\ProjectJobController;

Route::prefix('crew')->group(function () {
    Route::prefix('endorsement')->group(function () {
        Route::get('/', [EndorsementPositionController::class, 'index'])
            ->name('crew.endorsement.index');

        Route::prefix('positions')->group(function () {
            Route::post('/{position}', [EndorsementPositionController::class, 'store'])
                ->name('crew.endorsement.position.store');
            Route::get('/{position}', [EndorsementPositionController::class, 'show'])
                ->name('crew.endorsement.position.show');

            // TODO: Delete?
            Route::get('endorsed/{position}', [EndorsementEndorsedController::class, 'index'])
                ->name('crew.endorsement.endorsed');

            Route::delete('request/{endorsementRequest}', [EndorsementRequestController::class, 'destroy'])
                ->name('crew.endorsement.request.destroy');
        });
    });

    Route::prefix('projects')->group(function () {
        Route::get('/job/{projectJob}', [ProjectJobController::class, 'show'])
            ->name('crew.project.job');
    });
});

// TODO: defer to common route for both crew and admin
Route::post('/crew/messages', [MessageController::class, 'store'])
    ->name('crew.messages.store');

Route::prefix('crew/profile')->group(function () {
    Route::get('/', [CrewProfileController::class, 'index'])
        ->name('crew.profile.index');
    Route::get('create', [CrewProfileController::class, 'create'])
        ->name('crew.profile.create');
    Route::post('', [CrewProfileController::class, 'store'])
        ->name('crew.profile.store');
    Route::get('edit', [CrewProfileController::class, 'edit'])
        ->name('crew.profile.edit');
    Route::put('', [CrewProfileController::class, 'update'])
        ->name('crew.profile.update');
});

Route::post('/crew/photos', [CrewProfileController::class, 'storePhoto']);

Route::get('/crew/positions/list', [\App\Http\Controllers\Crew\CrewPositionController::class, 'getPositionList'])
    ->name('crew-positions-list');
Route::get('/crew/positions/{position}/show', [\App\Http\Controllers\Crew\CrewPositionController::class, 'getPositionData']);
Route::post('/crew/positions/{position}', [\App\Http\Controllers\Crew\CrewPositionController::class, 'store'])
    ->name('crew-position.store');
Route::delete('/crew/positions/{position}/resume', [CrewPositionController::class, 'removeResume']);
Route::get('/crew/positions/{position}/reel', [CrewPositionController::class, 'removeReel']);
