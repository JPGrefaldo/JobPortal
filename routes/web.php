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
        Route::put('/admin/users/ban/{user}', 'Admin\AdminUsersController@updateBan');

        Route::prefix('/admin/departments')->group(function () {
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


        // TODO: discuss if this should be public
        Route::get('/crew/positions/', 'Crew\PositionController@index')->name('crew_position.index');
        Route::get('/crew/positions/{position}', 'Crew\PositionController@show')->name('crew_position.show');
        Route::post('/crew/positions/{position}', 'Crew\PositionController@store')->name('crew_position.store');
        Route::post('/crew/positions/', 'Crew\CrewPositionsController@store');

        Route::post('/crew/positions/{position}/endorsement-requests', 'Crew\EndorsementRequestController@store')->name('endorsement_requests.store');

        /**
         * endorsements resource
         */
        Route::get('/endorsement-requests/{endorsementRequest}/endorsements/create', 'Crew\EndorsementController@create')->name('endorsements.create');
        Route::post('/endorsement-requests/{endorsementRequest}/endorsements', 'Crew\EndorsementController@store')->name('endorsements.store');
        Route::get('/endorsement-requests/{endorsementRequest}/endorsements/edit', 'Crew\EndorsementController@edit')->name('endorsements.edit');
        Route::put('/endorsement-requests/{endorsementRequest}/endorsements/update', 'Crew\EndorsementController@update')->name('endorsements.update');
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
            Route::post('/', 'Producer\ProjectsController@store');
            Route::put('/{project}', 'Producer\ProjectsController@update');
        });
        Route::prefix('/producer/jobs')->group(function () {
            Route::post('/', 'Producer\ProjectJobsController@store');
            Route::put('/{job}', 'Producer\ProjectJobsController@update');
        });
    });
});
