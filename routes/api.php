<?php

use App\Http\Controllers\API\Admin\FlaggedMessageController;
use App\Http\Controllers\API\Admin\ProjectJobSubmissionController;
use App\Http\Controllers\API\Crew\DepartmentController;
use App\Http\Controllers\API\Crew\PositionController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\ParticipantController;
use App\Http\Controllers\API\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\API\Producer\MessageTemplateController;
use App\Http\Controllers\API\Producer\ProjectJobController;
use App\Http\Controllers\API\Producer\ProjectTypes;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\API\SubmissionController;
use App\Http\Controllers\API\ThreadController;
use App\Http\Controllers\API\UserController;
use App\Models\ProjectType;

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

Route::middleware('auth:api')->group(function () {

    Route::put('/admin/projects/{project}/approve', [
        AdminProjectController::class, 
        'approve'
    ])->middleware('role:Admin')->name('admin.projects.approve');

    Route::put('/admin/projects/{project}/unapprove', [
        AdminProjectController::class, 
        'unapprove'
    ])->middleware('role:Admin')->name('admin.projects.unapprove');

    Route::get('/admin/projects/pending', [
        AdminProjectController::class, 
        'unapproved'
    ])->middleware('role:Admin')->name('admin.pending-projects');

    Route::get('/admin/flag-messages', [
        FlaggedMessageController::class,
        'index',
    ])->middleware('role:Admin')->name('admin.messages.flagged');



    Route::get('/user', [
        UserController::class,
        'show',
    ]);

    Route::get('/crew/departments', [
        DepartmentController::class,
        'index',
    ])->name('crew.departments.index');

    Route::get('/crew/positions', [
        PositionController::class,
        'index',
    ])->name('crew.positions.index');

    Route::get('/sites', [
        SiteController::class,
        'index',
    ])->name('sites.index');

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

    Route::get('/crew/projects/{project}/threads', [
        ThreadController::class,
        'index',
    ])->name('crew.threads.index');

    Route::prefix('producer')->middleware('role:Producer')->group(function () {
        Route::prefix('projects')->group(function () {
            Route::get('submissions/{job}', [
                ProjectJobSubmissionController::class,
                'index',
            ])->name('project.job.submissions.index');

            Route::get('/', [
                ProjectController::class,
                'index',
            ])->name('producer.projects.index');

            Route::post('/', [
                ProjectController::class,
                'store',
            ])->name('producer.project.store');

            Route::put('/{project}', [
                ProjectController::class,
                'update',
            ])->name('producer.projects.update');

            Route::get('/{project}/threads', [
                ThreadController::class,
                'index',
            ])->name('producer.threads.index');

            Route::prefix('{project}/messages/crew')->group(function () {
                Route::post('save', [
                    MessageController::class,
                    'storeCrew',
                ])->name('producer.message.crew.store');
                Route::post('update', [
                    MessageController::class,
                    'updateCrew',
                ])->name('producer.message.crew.update');
            });

            Route::get('/approved', [
                ProjectController::class,
                'approved',
            ])->name('producer.projects.approved');

            Route::prefix('jobs')->group(function () {
                Route::get('/', [
                    ProjectJobController::class,
                    'index',
                ])->name('producer.project.jobs');

                Route::post('/', [
                    ProjectJobController::class,
                    'store',
                ])->name('producer.project.jobs.store');

                Route::put('/{projectJob}', [
                    ProjectJobController::class,
                    'update',
                ])->name('producer.project.jobs.update');

                Route::delete('/{projectJob}', [
                    ProjectJobController::class,
                    'destroy',
                ])->name('producer.project.jobs.destroy');

                Route::get('/{projectJob}/submissions/all-approved', [
                    SubmissionController::class,
                    'fetchByApprovedDate',
                ])->name('fetch.submissions.by.approved');
            });

            Route::prefix('submissions')->group(function () {
                Route::post('{submission}/approve', [
                    SubmissionController::class,
                    'approve',
                ])->name('producer.projects.approve.submissions');

                Route::post('{submission}/reject', [
                    SubmissionController::class,
                    'reject',
                ])->name('producer.projects.submissions.reject');

                Route::post('{submission}/restore', [
                    SubmissionController::class,
                    'restore',
                ])->name('producer.projects.submissions.restore');

                Route::post('{submissionToReject}/{submissionToApprove}/swap', [
                    SubmissionController::class,
                    'swap',
                ])->name('producer.projects.swap.submissions');
            });

            Route::get('/pending', [
                ProjectController::class,
                'pending',
            ])->name('producer.projects.pending');

            Route::get('/type', [
                ProjectTypes::class,
                'index',
            ])->name('producer.project.type');
        });
    
        Route::prefix('messages')->group(function () {
            Route::get('/', [
                MessageController::class,
                'index'
            ])->name('producer.messages');

            Route::prefix('templates')->group(function () {
                Route::get('/', [
                    MessageTemplateController::class,
                    'index',
                ])->name('producer.messages.templates');

                Route::post('/', [
                    MessageTemplateController::class,
                    'store',
                ])->name('producer.messages.templates');
            });
        });

        Route::get('/pending', [
            ProjectController::class,
            'pending',
        ])->name('producer.projects.pending');

        Route::get('/type', [
            ProjectType::class,
            'index',
        ])->name('producer.project.type');
    });


    Route::prefix('submissions')->group(function () {
        Route::get('/{job}', [
            ProjectJobSubmissionController::class,
            'index',
        ])->middleware('role:Admin')->name('admin.project.job.submissions.index');

        Route::post('/{job}', [
            ProjectJobSubmissionController::class,
            'store',
        ])->middleware('role:Crew')->name('project.job.submissions.store');
    });
});
