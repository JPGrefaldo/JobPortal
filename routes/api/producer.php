<?php

use App\Http\Controllers\API\Admin\ProjectJobSubmissionController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\Producer\MessageTemplateController;
use App\Http\Controllers\API\Producer\ProjectJobController;
use App\Http\Controllers\API\Producer\ProjectTypes;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\SubmissionController;
use App\Http\Controllers\API\ThreadController;

Route::post('/jobs', [ProjectJobController::class, 'store'])->name('producer.jobs');
Route::put('/jobs/{job}', [ProjectJobController::class, 'update'])->name('producer.job.update');

Route::get('/messages', [MessageController::class, 'index',])->name('producer.messages');

Route::post('projects/{project}/messages/crew/update', [MessageController::class, 'updateCrew',])->name('producer.message.crew.update');

Route::post('projects/{project}/messages/crew/save', [MessageController::class, 'storeCrew',])->name('producer.message.crew.store');

Route::get('messages/templates', [MessageTemplateController::class, 'index',])->name('producer.messages.templates');

Route::post('messages/templates', [MessageTemplateController::class, 'store',])->name('producer.messages.templates');

Route::get('/projects', [ProjectController::class, 'index',])->name('producer.projects.index');

Route::post('/projects', [ProjectController::class, 'store',])->name('producer.project.store');

Route::put('projects/{project}', [ProjectController::class, 'update',])->name('producer.projects.update');

Route::get('projects/approved', [ProjectController::class, 'approved',])->name('producer.projects.approved');

Route::get('projects/pending', [ProjectController::class, 'pending',])->name('producer.projects.pending');

Route::get('projects/jobs', [ProjectJobController::class, 'index',])->name('producer.project.jobs');

Route::post('projects/jobs', [ProjectJobController::class, 'store',])->name('producer.project.jobs.store');

Route::put('projects/jobs/{projectJob}', [ProjectJobController::class, 'update',])->name('producer.project.jobs.update');

Route::delete('projects/jobs/{projectJob}', [ProjectJobController::class, 'destroy',])->name('producer.project.jobs.destroy');

Route::get('projects/submissions/{job}', [ProjectJobSubmissionController::class, 'index',])->name('project.job.submissions.index');

Route::get('projects/type', [ProjectTypes::class, 'index',])->name('producer.project.type');

Route::get('projects/jobs/{projectJob}/submissions/all-approved', [SubmissionController::class, 'fetchByApprovedDate',])->name('fetch.submissions.by.approved');

Route::post('projects/submissions/{submission}/approve', [SubmissionController::class, 'approve',])->name('producer.projects.approve.submissions');

Route::post('projects/submissions/{submission}/reject', [SubmissionController::class, 'reject',])->name('producer.projects.submissions.reject');

Route::post('projects/submissions/{submission}/restore', [SubmissionController::class, 'restore',])->name('producer.projects.submissions.restore');

Route::post('projects/submissions/{submissionToReject}/{submissionToApprove}/swap', [SubmissionController::class, 'swap',])->name('producer.projects.swap.submissions');

Route::get('projects/{project}/threads', [ThreadController::class, 'index',])->name('producer.threads.index');
