<?php

use App\Http\Controllers\API\Admin\FlaggedMessageController;
use App\Http\Controllers\API\Admin\ProjectController;
use App\Http\Controllers\API\Admin\ProjectJobSubmissionController;
use App\Http\Controllers\API\DepartmentController;

Route::get('/departments', [DepartmentController::class, 'index'])->name('admin.departments');

Route::post('/departments', [DepartmentController::class, 'store'])->name('admin.departments.store');

Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('admin.departments.update');

Route::get('/flag-messages', [FlaggedMessageController::class, 'index',])->name('admin.messages.flagged');

Route::put('/projects/{project}/approve', [ProjectController::class, 'approve',])->name('admin.projects.approve');

Route::put('/projects/{project}/unapprove', [ProjectController::class, 'unapprove',])->name('admin.projects.unapprove');

Route::post('/projects/{project}/deny', [ProjectController::class, 'deny',])->name('admin.projects.deny');

Route::get('/projects/pending', [ProjectController::class, 'unapproved',])->name('admin.pending-projects');

Route::get('submissions/{job}', [ProjectJobSubmissionController::class, 'index',])->name('admin.project.job.submissions.index');
