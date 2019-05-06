<?php

Route::prefix('crew')->group(function () {
    Route::prefix('endorsement')->group(function () {
        Route::get('/', [App\Http\Controllers\Crew\Endorsements\EndorsementPositionController::class, 'index'])
            ->name('crew.endorsement.index');

        Route::prefix('positions')->group(function () {
            Route::post('/{position}', [\App\Http\Controllers\Crew\Endorsements\EndorsementPositionController::class, 'store'])
                ->name('crew.endorsement.position.store');
            Route::get('/{position}', [\App\Http\Controllers\Crew\Endorsements\EndorsementPositionController::class, 'show'])
                ->name('crew.endorsement.position.show');

            // TODO: Delete?
            Route::get('endorsed/{position}', [App\Http\Controllers\Crew\Endorsements\EndorsementEndorsedController::class, 'index'])
                ->name('crew.endorsement.endorsed');

            Route::delete('request/{endorsementRequest}', [\App\Http\Controllers\Crew\Endorsements\EndorsementRequestController::class, 'destroy'])
                ->name('crew.endorsement.request.destroy');
        });
    });

    Route::prefix('projects')->group(function () {
        Route::get('/job/{projectJob}', [\App\Http\Controllers\Crew\ProjectJobsController::class, 'show'])
            ->name('crew.project.job');
    });
});

// TODO: defer to common route for both crew and admin
Route::post('/crew/messages', [\App\Http\Controllers\Crew\MessageController::class, 'store'])
    ->name('crew.messages.store');

Route::prefix('crew/profile')->group(function () {
    Route::get('/', [\App\Http\Controllers\Crew\CrewProfileController::class, 'index'])
        ->name('crew.profile');

    Route::get('edit', [\App\Http\Controllers\Crew\CrewProfileController::class, 'create'])
        ->name('crew.profile.create');
    Route::post('edit', [\App\Http\Controllers\Crew\CrewProfileController::class, 'store']);
    Route::put('edit', [\App\Http\Controllers\Crew\CrewProfileController::class, 'update']);
});

Route::post('/crew/positions/{position}', [\App\Http\Controllers\Crew\CrewPositionController::class, 'applyFor'])
    ->name('crew-position.store');
Route::put('/crew/positions/{position}', [\App\Http\Controllers\Crew\CrewPositionController::class, 'update'])
    ->name('crew-position.update');

Route::get('/crew/crew-positions', [\App\Http\Controllers\Crew\CrewPositionController::class, 'checkCrewPositions']);
Route::get('/crew/crew-positions/{position}', [\App\Http\Controllers\Crew\CrewPositionController::class, 'fetchCrewPosition']);
