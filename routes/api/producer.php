<?php

use App\Http\Controllers\API\Producer\ProjectJobController;

Route::post('/producer/jobs', [ProjectJobController::class, 'store'])
    ->name('producer.jobs');
Route::put('/producer/jobs/{job}', [ProjectJobController::class, 'update'])
    ->name('producer.job.update');
