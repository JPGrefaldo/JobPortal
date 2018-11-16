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
*/

Route::get('/', 'IndexController@index');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('logout', 'Auth\LoginController@logout');

Route::get('signup', 'Auth\UserSignupController@show')->name('signup');
Route::post('signup', 'Auth\UserSignupController@signup');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('verify/email/{code}', 'VerifyEmailController@verify')->name('verify.email');


Route::middleware('auth')->group(function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::prefix('crew/profile')->group(function () {
        Route::get('/', 'Crew\CrewProfileController@index')->name('profile');
        Route::get('edit', 'Crew\CrewProfileController@create')->name('profile.create');
        Route::post('/', 'Crew\CrewProfileController@store');
    });

    Route::prefix('account')->group(function () {
        Route::get('name', 'Account\AccountNameController@index')->name('account.name');
        Route::post('name', 'Account\AccountNameController@store');

        Route::get('contact', 'Account\AccountContactController@index')->name('account.contact');
        Route::post('contact', 'Account\AccountContactController@store');

        Route::get('subscription', 'Account\AccountSubscriptionController@index')->name('account.subscription');
        Route::post('subscription', 'Account\AccountSubscriptionController@store');

        Route::get('password', 'Account\AccountPasswordController@index')->name('account.password');
        Route::post('password', 'Account\AccountPasswordController@store');

        Route::get('manager', 'Account\AccountManagerController@index')->name('account.manager');
        Route::post('manager', 'Account\AccountManagerController@index');

        Route::get('notifications', 'Account\AccountNotificationsController@index')->name('account.notifications');
        Route::post('notifications', 'Account\AccountNotificationsController@store');

        Route::get('close', 'Account\AccountCloseController@index')->name('account.close');
        Route::put('close', 'Account\AccountCloseController@destroy');

        Route::put('settings/name', 'User\UserSettingsController@updateName');
        Route::put('settings/notifications', 'User\UserSettingsController@updateNotifications');
        Route::put('settings/password', 'User\UserSettingsController@updatePassword');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    |
    | User must have Admin role
    |
     */
    Route::middleware('admin')->group(function () {
        Route::put('/admin/users/ban/{user}', 'Admin\AdminUsersController@updateBan')
            ->name('admin.users.ban');

        Route::prefix('/admin/sites')->group(function () {
            Route::get('/', 'Admin\SiteController@index')->name('admin.sites');
        });

        Route::prefix('/admin/departments')->group(function () {
            Route::get('/', 'Admin\DepartmentsController@index')->name('admin.departments');
            Route::post('/', 'Admin\DepartmentsController@store');
            Route::put('/{department}', 'Admin\DepartmentsController@update');
        });

        Route::prefix('/admin/positions')->group(function () {
            Route::get('/', 'Admin\PositionsController@index')->name('admin.positions');
            Route::post('/', 'Admin\PositionsController@store');
            Route::put('/{position}', 'Admin\PositionsController@update');
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
        Route::post('/crews', 'CrewsController@store');
        Route::put('/crews/{crew}', 'CrewsController@update');


        Route::prefix('crew')->group(function () {
            Route::prefix('endorsement')->group(function () {
                Route::get('/', 'Crew\Endorsements\EndorsementPositionController@index')
                    ->name('crew.endorsement.index');

                Route::prefix('positions')->group(function () {
                    Route::get('/{position}/create', 'Crew\Endorsements\EndorsementPositionController@create')
                        ->name('crew.endorsement.position.create');
                    Route::post('/{position}', 'Crew\Endorsements\EndorsementPositionController@store')
                        ->name('crew.endorsement.position.store');
                    Route::get('/{position}', 'Crew\Endorsements\EndorsementPositionController@show')
                        ->name('crew.endorsement.position.show');
                    Route::get('/{position}/edit', 'Crew\Endorsements\EndorsementPositionController@edit')
                        ->name('crew.endorsement.position.edit');
                    Route::put('/{position}', 'Crew\Endorsements\EndorsementPositionController@update')
                        ->name('crew.endorsement.position.update');
                    Route::delete('/{position}', 'Crew\Endorsements\EndorsementPositionController@destroy')
                        ->name('crew.endorsement.position.destroy');
                });
            });
        });

        Route::post('/crew/positions/{position}/endorsement-requests', 'Crew\Endorsements\EndorsementRequestController@store')
            ->name('endorsement_requests.store');

        /**
         * endorsements resource
         */
        Route::get('/endorsement-requests/{endorsementRequest}/endorsements/create', 'Crew\Endorsements\EndorsementController@create')
            ->name('endorsements.create');
        Route::post('/endorsement-requests/{endorsementRequest}/endorsements', 'Crew\Endorsements\EndorsementController@store')
            ->name('endorsements.store');
        Route::get('/endorsement-requests/{endorsementRequest}/endorsements/edit', 'Crew\Endorsements\EndorsementController@edit')
            ->name('endorsements.edit');
        Route::put('/endorsement-requests/{endorsementRequest}/endorsements/update', 'Crew\Endorsements\EndorsementController@update')
            ->name('endorsements.update');
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
            Route::get('/create', 'Producer\ProjectsController@create')->name('producer.projects.create');
            Route::post('/', 'Producer\ProjectsController@store');
            Route::put('/{project}', 'Producer\ProjectsController@update');
        });
        Route::prefix('/producer/jobs')->group(function () {
            Route::post('/', 'Producer\ProjectJobsController@store');
            Route::put('/{job}', 'Producer\ProjectJobsController@update');
        });

        Route::group(['prefix' => 'messages'], function () {
            //     Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
            //     Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
            Route::post('/{project}', ['as' => 'producer.messages.store', 'uses' => 'Producer\MessagesController@store']);
            //     Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
        //     Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
        });
    });

    // Route::group(['prefix' => 'messages'], function () {
        //     Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
        //     Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
        // Route::post('/', ['as' => 'producer.messages.store', 'uses' => 'Producer\MessagesController@store']);
        //     Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
        //     Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
    // });
});

Route::prefix('theme')->group(function () {
    Route::view('/', 'theme.index');
});


Route::get('test', function () {
    Log::info('asd');
});
