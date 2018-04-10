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
Route::post('/signup/crew', 'UserSignupController@createCrew');

Route::get('/verify/email/{code}', 'VerifyEmailController@verify');

Route::get('/home', 'HomeController@index')->name('home');
