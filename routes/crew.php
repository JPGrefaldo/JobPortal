<?php

Route::post('/crews', [\App\Http\Controllers\CrewsController::class, 'store'])
    ->name('crews');
Route::put('/crews/{crew}', [\App\Http\Controllers\CrewsController::class, 'update'])
    ->name('crews.update');

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
});

// TODO: defer to common route for both crew and admin
Route::post('/crew/messages', [\App\Http\Controllers\Crew\MessageController::class, 'store'])
    ->name('crew.messages.store');

Route::prefix('crew/profile')->group(function () {
    Route::get('/', [\App\Http\Controllers\Crew\CrewProfileController::class, 'index'])
        ->name('profile');
    Route::get('edit', [\App\Http\Controllers\Crew\CrewProfileController::class, 'create'])
        ->name('profile.create');
    Route::post('/', [\App\Http\Controllers\Crew\CrewProfileController::class, 'store']);
});
