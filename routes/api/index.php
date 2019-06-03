<?php

use App\Http\Controllers\API\Admin\FlaggedMessageController;
use App\Http\Controllers\API\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\API\Admin\ProjectJobSubmissionController;
use App\Http\Controllers\API\Crew\PositionController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\ParticipantController;
use App\Http\Controllers\API\Producer\MessageTemplateController;
use App\Http\Controllers\API\Producer\ProjectJobController;
use App\Http\Controllers\API\Producer\ProjectTypes;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\API\SubmissionController;
use App\Http\Controllers\API\ThreadController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Crew\CrewProjectController;
use App\Http\Controllers\Producer\ProjectController as ProducerProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
| You can add role specific middlewares through:
| * Single, Route::middleware(AuthorizeRoles::parameterize(Role::CREW))
| * Multiple, Route::middleware(AuthorizeRoles::parameterize(Role::CREW, Role::PRODUCER))
*/
// TODO: defer to common route for both crew and admin
Route::post('/messages/{project}', [MessageController::class, 'store'])
    ->name('producer.messages.store');
// TODO: defer to common route for both crew and admin
Route::put('/messages/producer/projects/{project}/messages/{message}', [MessageController::class, 'update'])
    ->name('producer.messages.update');

// web
Route::get('/producer/projects', [ProducerProjectController::class, 'index'])
    ->name('producer.projects');
Route::get('/producer/projects/create', [ProducerProjectController::class, 'create'])
    ->name('producer.projects.create');
Route::get('/producer/projects/edit/{project}', [ProducerProjectController::class, 'edit'])
    ->name('producer.projects.edit');


Route::middleware('auth:api')->group(function () {
    Route::prefix('admin')->middleware('role:Admin')->group(function () {
        Route::get('/departments', [
            DepartmentController::class,
            'index'
        ])->name('admin.departments');

        Route::post('/departments', [
            DepartmentController::class,
            'store'
        ])->name('admin.departments.store');

        Route::put('/departments/{department}', [
            DepartmentController::class,
            'update'
        ])->name('admin.departments.update');

        Route::get('/flag-messages', [
            FlaggedMessageController::class,
            'index',
        ])->name('admin.messages.flagged');

        Route::put('/projects/{project}/approve', [
            AdminProjectController::class,
            'approve',
        ])->name('admin.projects.approve');

        Route::put('/projects/{project}/unapprove', [
            AdminProjectController::class,
            'unapprove',
        ])->name('admin.projects.unapprove');

        Route::post('/projects/{project}/deny', [
            AdminProjectController::class,
            'deny',
        ])->name('admin.projects.deny');

        Route::get('/projects/pending', [
            AdminProjectController::class,
            'unapproved',
        ])->name('admin.pending-projects');

        Route::get('submissions/{job}', [
            ProjectJobSubmissionController::class,
            'index',
        ])->name('admin.project.job.submissions.index');
    });

    Route::prefix('crew')->middleware('role:Crew')->group(function () {
        Route::get('/departments', [
            DepartmentController::class,
            'index',
        ])->name('crew.departments.index');

        Route::get('/positions', [
            PositionController::class,
            'index',
        ])->name('crew.positions.index');

        Route::get('/projects', [
            CrewProjectController::class,
            'index',
        ])->name('crew.projects.index');

        Route::get('/projects/{project}/threads', [
            ThreadController::class,
            'index',
        ])->name('crew.threads.index');

        Route::post('/submission/{job}', [
            SubmissionController::class,
            'store',
        ])->name('crew.submissions.store');

        Route::get('/submission/{job}/check', [
            SubmissionController::class,
            'check',
        ])->name('crew.submission.check');
    });

    Route::post('/messenger/projects/{project}/messages', [
        MessageController::class,
        'store',
    ])->middleware('role:Producer|Crew')->name('messenger.project.messages.store');

    Route::get('/messenger/threads/{thread}/messages', [
        MessageController::class,
        'index',
    ])->middleware('role:Producer|Crew')->name('messenger.threads.messages.index');

    Route::put('/messenger/threads/{thread}/messages', [
        MessageController::class,
        'update',
    ])->middleware('role:Producer|Crew')->name('messenger.threads.messages.update');

    Route::post('/messenger/threads/{thread}/search', [
        ParticipantController::class,
        'search',
    ])->middleware('role:Producer|Crew')->name('threads.index.search');


    Route::get('/sites', [
        SiteController::class,
        'index',
    ])->name('sites.index');


    Route::get('/user', [
        UserController::class,
        'show',
    ]);

    Route::prefix('producer')->middleware('role:Producer')->group(function () {
        Route::get('/messages', [
            MessageController::class,
            'index',
        ])->name('producer.messages');

        Route::post('projects/{project}/messages/crew/update', [
            MessageController::class,
            'updateCrew',
        ])->name('producer.message.crew.update');

        Route::post('projects/{project}/messages/crew/save', [
            MessageController::class,
            'storeCrew',
        ])->name('producer.message.crew.store');

        Route::get('messages/templates', [
            MessageTemplateController::class,
            'index',
        ])->name('producer.messages.templates');

        Route::post('messages/templates', [
            MessageTemplateController::class,
            'store',
        ])->name('producer.messages.templates');

        Route::get('/projects', [
            ProjectController::class,
            'index',
        ])->name('producer.projects.index');

        Route::post('/projects', [
            ProjectController::class,
            'store',
        ])->name('producer.project.store');

        Route::put('projects/{project}', [
            ProjectController::class,
            'update',
        ])->name('producer.projects.update');

        Route::get('projects/approved', [
            ProjectController::class,
            'approved',
        ])->name('producer.projects.approved');

        Route::get('projects/pending', [
            ProjectController::class,
            'pending',
        ])->name('producer.projects.pending');

        Route::get('projects/jobs', [
            ProjectJobController::class,
            'index',
        ])->name('producer.project.jobs');

        Route::post('projects/jobs', [
            ProjectJobController::class,
            'store',
        ])->name('producer.project.jobs.store');

        Route::put('projects/jobs/{projectJob}', [
            ProjectJobController::class,
            'update',
        ])->name('producer.project.jobs.update');

        Route::delete('projects/jobs/{projectJob}', [
            ProjectJobController::class,
            'destroy',
        ])->name('producer.project.jobs.destroy');

        Route::get('projects/submissions/{job}', [
            ProjectJobSubmissionController::class,
            'index',
        ])->name('project.job.submissions.index');

        Route::get('projects/type', [
            ProjectTypes::class,
            'index',
        ])->name('producer.project.type');

        Route::get('projects/jobs/{projectJob}/submissions/all-approved', [
            SubmissionController::class,
            'fetchByApprovedDate',
        ])->name('fetch.submissions.by.approved');

        Route::post('projects/submissions/{submission}/approve', [
            SubmissionController::class,
            'approve',
        ])->name('producer.projects.approve.submissions');

        Route::post('projects/submissions/{submission}/reject', [
            SubmissionController::class,
            'reject',
        ])->name('producer.projects.submissions.reject');

        Route::post('projects/submissions/{submission}/restore', [
            SubmissionController::class,
            'restore',
        ])->name('producer.projects.submissions.restore');

        Route::post('projects/submissions/{submissionToReject}/{submissionToApprove}/swap', [
            SubmissionController::class,
            'swap',
        ])->name('producer.projects.swap.submissions');

        Route::get('projects/{project}/threads', [
            ThreadController::class,
            'index',
        ])->name('producer.threads.index');
    });
});
