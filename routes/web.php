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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/signup', 'Auth\RegisterController@showRegistrationForm');
Route::post('/signup', 'UserSignupController@signup');

Route::get('/verify/email/{code}', 'VerifyEmailController@verify');

Route::get('/home', 'HomeController@index')->name('home');


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

    Route::prefix('/admin/departments')->group(function() {
        Route::post('/', 'Admin\DepartmentsController@store');
        Route::put('/{department}', 'Admin\DepartmentsController@update');
    });

    Route::prefix('/admin/positions')->group(function() {
        Route::post('/', 'Admin\PositionsController@store');
        Route::put('/{position}', 'Admin\PositionsController@update');
    });
});

Route::middleware(['auth', 'producer'])->group(function () {
    Route::prefix('/producer/projects')->group(function() {
        Route::post('/', 'Producer\ProjectsController@store');
        Route::put('/{project}', 'Producer\ProjectsController@update');
    });
});
