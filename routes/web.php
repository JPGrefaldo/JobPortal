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
Route::post('login', 'Auth\LoginController@login')->name('show.login');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('logout', 'Auth\LoginController@logout');

Route::get('register', 'UserSignupController@show')->name('show.register');
Route::post('register', 'UserSignupController@signup')->name('register');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/my-profile', 'ProfileController@index');
Route::get('/my-profile/edit', 'ProfileController@showEditProfile');

Route::get('/my-projects', 'ProjectController@index');
Route::get('/my-projects/post', 'ProjectController@showPostProject');

Route::get('/my-account', 'AccountController@index');

Route::get('/verify/email/{code}', 'VerifyEmailController@verify');

Route::middleware('auth')->group(function () {
    Route::put('/account/settings/name', 'User\UserSettingsController@updateName');
    Route::put('/account/settings/notifications', 'User\UserSettingsController@updateNotifications');
    Route::put('/account/settings/password', 'User\UserSettingsController@updatePassword');
});

Route::middleware(['auth', 'crew'])->group(function () {
    Route::post('/crews', 'CrewsController@store');
    Route::put('/crews/{crew}', 'CrewsController@update');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::put('/admin/users/ban/{user}', 'Admin\AdminUsersController@updateBan');

    Route::prefix('/admin/departments')->group(function () {
        Route::post('/', 'Admin\DepartmentsController@store');
        Route::put('/{department}', 'Admin\DepartmentsController@update');
    });

    Route::prefix('/admin/positions')->group(function () {
        Route::post('/', 'Admin\PositionsController@store');
        Route::put('/{position}', 'Admin\PositionsController@update');
    });
});

Route::middleware(['auth', 'producer'])->group(function () {
    Route::prefix('/producer/projects')->group(function () {
        Route::post('/', 'Producer\ProjectsController@store');
        Route::put('/{project}', 'Producer\ProjectsController@update');
    });
    Route::prefix('/producer/jobs')->group(function () {
        Route::post('/', 'Producer\ProjectJobsController@store');
        Route::put('/{job}', 'Producer\ProjectJobsController@update');
    });
});

Route::middleware(['auth', 'crew'])->group(function () {
    Route::get('/crew/positions/{position}', 'Crew\PositionController@show')->name('crew_position.show');

    Route::post('/crew/positions/{position}/endorsement-requests', 'Crew\EndorsementRequestController@store')->name('endorsement_request.store');

    /**
     * endorsements resource
     */
    Route::get('/endorsement-requests/{endorsementRequest}/endorsements/create', 'Crew\EndorsementController@create')->name('endorsement.create');
    Route::post('/endorsement-requests/{endorsementRequest}/endorsements', 'Crew\EndorsementController@store')->name('endorsement.store');
    Route::get('/endorsement-requests/{endorsementRequest}/endorsements/edit', 'Crew\EndorsementController@edit')->name('endorsement.edit');
    Route::put('/endorsement-requests/{endorsementRequest}/endorsements/update', 'Crew\EndorsementController@update')->name('endorsement.update');
});

Route::get('/positions/{position}/endorsements', 'Crew\EndorsementController@index');
