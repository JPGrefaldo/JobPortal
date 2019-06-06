<?php

use App\Http\Controllers\API\Crew\PositionController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\SubmissionController;
use App\Http\Controllers\API\ThreadController;
use App\Http\Controllers\Crew\CrewPositionController;
use App\Http\Controllers\Crew\CrewProjectController;
use App\Http\Controllers\Crew\Endorsements\EndorsementEndorsedController;
use App\Http\Controllers\Crew\Endorsements\EndorsementPositionController;
use App\Http\Controllers\Crew\Endorsements\EndorsementRequestController;

Route::post('/positions/{position}', [CrewPositionController::class, 'store'])->name('crew-position.store');
Route::delete('/positions/{position}/delete', [CrewPositionController::class, 'destroy'])->name('crew-position.delete');
Route::delete('/positions/{position}/resume', [CrewPositionController::class, 'removeResume']);

Route::post('/endorsement/positions/{position}', [EndorsementPositionController::class, 'store'])->name('crew.endorsement.position.store');

// TODO: Delete?
Route::get('/endorsement/positions/endorsed/{position}', [EndorsementEndorsedController::class, 'index'])->name('crew.endorsement.endorsed');

Route::delete('/endorsement/positions/request/{endorsementRequest}', [EndorsementRequestController::class, 'destroy'])->name('crew.endorsement.request.destroy');

Route::get('/departments', [DepartmentController::class, 'index',])->name('crew.departments.index');

Route::get('/ignored/jobs', [PositionController::class, 'ignored_jobs'])->name('crew.ignored.jobs');

Route::get('/positions', [PositionController::class, 'index',])->name('crew.positions.index');

Route::get('/projects', [CrewProjectController::class, 'index',])->name('crew.projects.index');

Route::get('/projects/{project}/threads', [ThreadController::class, 'index',])->name('crew.threads.index');

Route::post('/submission/{job}', [SubmissionController::class, 'store',])->name('crew.submissions.store');

Route::get('/submission/{job}/check', [SubmissionController::class, 'check',])->name('crew.submission.check');
