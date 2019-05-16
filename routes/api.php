<?php

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
    Route::get('/user', [
        \App\Http\Controllers\API\UserController::class,
        'show',
    ]);

    Route::get('/crew/departments', [
        \App\Http\Controllers\API\Crew\DepartmentController::class,
        'index',
    ])->name('crew.departments.index');

    Route::get('/crew/projects', [
        \App\Http\Controllers\API\Crew\ProjectController::class,
        'index',
    ])->name('crew.projects.index');

    Route::get('/crew/positions', [
        \App\Http\Controllers\API\Crew\PositionController::class,
        'index',
    ])->name('crew.positions.index');

    Route::get('/crew/sites', [
        \App\Http\Controllers\API\Crew\SiteController::class,
        'index',
    ])->name('crew.sites.index');


    Route::get('/threads/{thread}/messages', [
        \App\Http\Controllers\MessageController::class,
        'index',
    ])->middleware('role:Producer|Crew')->name('messages.index');

    Route::post('/threads/{thread}/messages', [
        \App\Http\Controllers\MessageController::class,
        'store',
    ])->middleware('role:Producer|Crew')->name('messages.store');

    Route::post('/threads/{thread}/participants', [
        \App\Http\Controllers\API\ParticipantController::class,
        'search',
    ])->middleware('role:Producer|Crew')->name('threads.search.participants');

    Route::get('/crew/projects/{project}/threads', [
        \App\Http\Controllers\Crew\ThreadController::class,
        'index',
    ])->name('crew.threads.index');

    Route::prefix('producer')->middleware('role:Producer')->group(function () {
        Route::prefix('projects')->group(function () {
            Route::get('submissions/{job}', [
                \App\Http\Controllers\API\Admin\ProjectJobSubmissionController::class,
                'index'
            ])->middleware('role:Producer')->name('project.job.submissions.index');

            Route::get('/', [
                \App\Http\Controllers\API\Producer\ProjectController::class,
                'index',
            ])->name('producer.projects.index');

            Route::post('/', [
                \App\Http\Controllers\API\Producer\ProjectController::class,
                'store',
            ])->name('producer.project.store');

            Route::put('/{project}', [
                \App\Http\Controllers\API\Producer\ProjectController::class,
                'update',
            ])->name('producer.projects.update');

            Route::get('/{project}/threads', [
                \App\Http\Controllers\Producer\ThreadController::class,
                'index',
            ])->name('producer.threads.index');

            Route::get('/approved', [
                \App\Http\Controllers\API\Producer\ProjectController::class,
                'approved',
            ])->name('producer.projects.approved');

            Route::prefix('jobs')->group(function () {
                Route::get('/', [
                    \App\Http\Controllers\API\Producer\ProjectJobController::class,
                    'index',
                ])->name('producer.project.jobs');

                Route::post('/', [
                    \App\Http\Controllers\API\Producer\ProjectJobController::class,
                    'store',
                ])->name('producer.project.jobs.store');

                Route::put('/{projectJob}', [
                    \App\Http\Controllers\API\Producer\ProjectJobController::class,
                    'update',
                ])->name('producer.project.jobs.update');

                Route::delete('/{projectJob}', [
                    \App\Http\Controllers\API\Producer\ProjectJobController::class,
                    'destroy',
                ])->name('producer.project.jobs.destroy');
            });

            Route::post('/submissions/{submission}/approve', [
                \App\Http\Controllers\API\SubmissionController::class,
                'approve'
            ])->name('producer.projects.submissions.approve');
        });

        Route::post('/submissions/{submission}/reject', [
            \App\Http\Controllers\API\SubmissionController::class,
            'reject'
        ])->name('producer.projects.submissions.reject');

        Route::post('/submissions/{submission}/restore', [
            \App\Http\Controllers\API\SubmissionController::class,
            'restore'
        ])->name('producer.projects.submissions.restore');

        Route::get('/pending', [
            \App\Http\Controllers\API\Producer\ProjectController::class,
            'pending',
        ])->name('producer.projects.pending');

        Route::get('/type', [
            \App\Http\Controllers\API\Producer\ProjectTypes::class,
            'index',
        ])->name('producer.project.type');

        Route::prefix('messages')->group(function () {
            Route::prefix('templates')->group(function () {
                Route::get('/', [
                    \App\Http\Controllers\API\Producer\MessageTemplateController::class,
                    'index'
                ])->name('producer.messages.templates');

                Route::post('/', [
                    \App\Http\Controllers\API\Producer\MessageTemplateController::class,
                    'store'
                ])->name('producer.messages.templates');
            });
        });

        Route::get('/pending', [
            \App\Http\Controllers\API\Producer\ProjectController::class,
            'pending',
        ])->name('producer.projects.pending');

        Route::get('/type', [
            \App\Http\Controllers\API\Producer\ProjectType::class,
            'index',
        ])->name('producer.project.type');
    });

    Route::get('/admin/flag-messages', [
        \App\Http\Controllers\Api\Admin\FlaggedMessageController::class,
        'index'
    ])->middleware('role:Admin')->name('admin.messages.flagged');

    Route::prefix('submissions')->group(function () {
        Route::get('/{job}', [
            \App\Http\Controllers\API\Admin\ProjectJobSubmissionController::class,
            'index'
        ])->middleware('role:Admin')->name('admin.project.job.submissions.index');

        Route::post('/{job}', [
            \App\Http\Controllers\API\Admin\ProjectJobSubmissionController::class,
            'store'
        ])->middleware('role:Crew')->name('project.job.submissions.store');
    });
});
