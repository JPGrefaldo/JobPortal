<?php
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserSignupController;
use App\Http\Controllers\Crew\CrewProjectController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Manager\ManagerConfirmationController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\VerifyEmailController;

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('confirm/{user}/{subordinate}', [ManagerConfirmationController::class, 'index'])->name('manager.confirm');

Route::get('current-projects', [CrewProjectController::class, 'showCurrentProjects'])->name('projects.current-projects');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

Route::get('about', [StaticPageController::class, 'showAbout'])->name('about');
Route::get('about/producers', [StaticPageController::class, 'showAboutProducers'])->name('about.producers');
Route::get('about/crew', [StaticPageController::class, 'showAboutCrew'])->name('about.crew');
Route::get('terms-and-conditions', [StaticPageController::class, 'showTermsAndConditions'])->name('termsandconditions');

Route::get('signup', [UserSignupController::class, 'show'])->name('signup');
Route::post('signup', [UserSignupController::class, 'signup'])->name('signup');

Route::get('verify/email/{code}', [VerifyEmailController::class, 'verify'])->name('verify.email');

Route::view('/theme', 'theme.index');

Route::get('test', function () {
    Log::info('asd');
});

Route::get('upload_test', function () {
    $name = uniqid() . '.txt';
    Storage::disk('s3')->put($name, (\Faker\Factory::create())->paragraph);
    dump(config('filesystems.disks.s3.url') . '/' . config('filesystems.disks.s3.bucket') . '/' . $name);
});

Route::post(
    'stripe/webhook',
    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);
