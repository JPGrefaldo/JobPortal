<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| You can add role specific middlewares through:
| * Single, Route::middleware(AuthorizeRoles::parameterize(Role::CREW))
| * Multiple, Route::middleware(AuthorizeRoles::parameterize(Role::CREW, Role::PRODUCER))
*/

Route::get('/', [\App\Http\Controllers\IndexController::class, 'index']);

Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])
    ->name('login');
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])
    ->name('login.post');

Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->name('logout');

Route::get('signup', [\App\Http\Controllers\Auth\UserSignupController::class, 'show'])
    ->name('signup');
Route::post('signup', [\App\Http\Controllers\Auth\UserSignupController::class, 'signup']);

Route::get('password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('password/email', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('password/reset/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('password/reset', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset']);

Route::get('verify/email/{code}', [\App\Http\Controllers\VerifyEmailController::class, 'verify'])
    ->name('verify.email');


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| User must be logged in
|
*/
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/messages', ['as' => 'messages', 'uses' => 'MessagesDashboardController@index']);

    Route::prefix('account')->group(function () {
        Route::get('name', [\App\Http\Controllers\Account\AccountNameController::class, 'index'])
            ->name('account.name');
        Route::post('name', [\App\Http\Controllers\Account\AccountNameController::class, 'store']);

        Route::get('contact', [\App\Http\Controllers\Account\AccountContactController::class, 'index'])
            ->name('account.contact');
        Route::post('contact', [\App\Http\Controllers\Account\AccountContactController::class, 'store']);

        Route::get('subscription', [\App\Http\Controllers\Account\AccountSubscriptionController::class, 'index'])
            ->name('account.subscription');
        Route::post('subscription', [\App\Http\Controllers\Account\AccountSubscriptionController::class, 'store']);

        Route::get('password', [\App\Http\Controllers\Account\AccountPasswordController::class, 'index'])
            ->name('account.password');
        Route::post('password', [\App\Http\Controllers\Account\AccountPasswordController::class, 'store']);

        Route::get('manager', [\App\Http\Controllers\Account\AccountManagerController::class, 'index'])
            ->name('account.manager');
        Route::post('manager', [\App\Http\Controllers\Account\AccountManagerController::class, 'index']);

        Route::get('notifications', [\App\Http\Controllers\Account\AccountNotificationsController::class, 'index'])
            ->name('account.notifications');
        Route::post('notifications', [\App\Http\Controllers\Account\AccountNotificationsController::class, 'store']);

        Route::get('close', [\App\Http\Controllers\Account\AccountCloseController::class, 'index'])
            ->name('account.close');
        Route::put('close', [\App\Http\Controllers\Account\AccountCloseController::class, 'destroy']);

        Route::put('settings/name', [\App\Http\Controllers\User\UserSettingsController::class, 'updateName']);
        Route::put('settings/notifications', [\App\Http\Controllers\User\UserSettingsController::class, 'updateNotifications']);
        Route::put('settings/password', [\App\Http\Controllers\User\UserSettingsController::class, 'updatePassword']);
    });

    Route::post('/pending-flag-messages', [\App\Http\Controllers\PendingFlagMessageController::class, 'store'])
        ->name('pending-flag-messages.store');

    Route::put('/pending-flag-messages/{pendingFlagMessage}', [\App\Http\Controllers\PendingFlagMessageController::class, 'update'])
        ->name('pending-flag-messages.update');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    |
    | User must have Admin role
    |
     */
    Route::middleware('admin')->group(function () {
        Route::put('/admin/users/ban/{user}', [\App\Http\Controllers\Admin\AdminUsersController::class, 'updateBan'])
            ->name('admin.users.ban');

        Route::prefix('/admin/sites')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SiteController::class, 'index'])
                ->name('admin.sites');
        });

        Route::prefix('/admin/departments')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\DepartmentsController::class, 'index'])
                ->name('admin.departments');
            Route::post('/', [\App\Http\Controllers\Admin\DepartmentsController::class, 'store']);
            Route::put('/{department}', [\App\Http\Controllers\Admin\DepartmentsController::class, 'update'])
                ->name('admin.departments.update');
        });

        Route::prefix('/admin/positions')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\PositionsController::class, 'index'])
                ->name('admin.positions');
            Route::post('/', [\App\Http\Controllers\Admin\PositionsController::class, 'store']);
            Route::put('/{position}', [\App\Http\Controllers\Admin\PositionsController::class, 'update'])
                ->name('admin.positions.update');
        });

        Route::prefix('/admin/projects')->group(function () {
            Route::put('/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'update'])
                ->name('admin.projects.update');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Crew Routes
    |--------------------------------------------------------------------------
    |
    | User must have Crew role
    |
    */
    Route::middleware('crew')->group(function () {
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
    });

    /*
    |--------------------------------------------------------------------------
    | Producer Routes
    |--------------------------------------------------------------------------
    |
    | User must have Producer role
    |
    */
    Route::middleware('producer')->group(function () {
        Route::prefix('/producer/projects')->group(function () {
            Route::get('/create', [\App\Http\Controllers\Producer\ProjectsController::class, 'create'])
                ->name('producer.projects.create');
            Route::post('/', [\App\Http\Controllers\Producer\ProjectsController::class, 'store'])
                ->name('producer.projects');
            Route::put('/{project}', [\App\Http\Controllers\Producer\ProjectsController::class, 'update'])
                ->name('producer.project.update');
        });

        Route::prefix('/producer/jobs')->group(function () {
            Route::post('/', [\App\Http\Controllers\Producer\ProjectJobsController::class, 'store'])
                ->name('producer.jobs');
            Route::put('/{job}', [\App\Http\Controllers\Producer\ProjectJobsController::class, 'update'])
                ->name('producer.job.update');
        });

        Route::group(['prefix' => 'messages'], function () {
            // TODO: defer to common route for both crew and admin
            Route::post('/{project}', [
                'as' => 'producer.messages.store',
                'uses' => 'Producer\MessagesController@store'
            ]);

            // TODO: defer to common route for both crew and admin
            Route::put('/producer/projects/{project}/messages/{message}', [
                'as' => 'producer.messages.update',
                'uses' => 'Producer\MessagesController@update'
            ]);
        });
    });
});

Route::prefix('theme')->group(function () {
    Route::view('/', 'theme.index');
});


Route::get('test', function () {
    Log::info('asd');
});

Route::get('upload_test', function () {
    $name = uniqid() . '.txt';
    Storage::disk('s3')->put($name, (\Faker\Factory::create())->paragraph);
    dump(config('filesystems.disks.s3.url') . '/' . config('filesystems.disks.s3.bucket') . '/' . $name);
});
