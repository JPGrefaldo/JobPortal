<?php

use App\Http\Controllers\Account\AccountChangeController;
use App\Http\Controllers\Account\AccountCloseController;
use App\Http\Controllers\Account\AccountContactController;
use App\Http\Controllers\Account\AccountManagerController;
use App\Http\Controllers\Account\AccountNameController;
use App\Http\Controllers\Account\AccountNotificationController;
use App\Http\Controllers\Account\AccountPasswordController;
use App\Http\Controllers\Account\AccountSubscriptionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserSignupController;
use App\Http\Controllers\Crew\CrewProfileController;
use App\Http\Controllers\Crew\CrewProjectController;
use App\Http\Controllers\Crew\Endorsements\EndorsementPositionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Manager\ManagerConfirmationController;
use App\Http\Controllers\MessageDashboardController;
use App\Http\Controllers\PendingFlagMessageController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\VerifyEmailController;

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
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/', [IndexController::class, 'index'])
    ->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login');
Route::post('login', [LoginController::class, 'login'])
    ->name('login.post');
Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::get('confirm/{user}/{subordinate}', [ManagerConfirmationController::class, 'index'])
    ->name('manager.confirm');

Route::get('current-projects', [CrewProjectController::class, 'showCurrentProjects'])
    ->name('projects.current-projects');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

Route::get('about', [StaticPageController::class, 'showAbout'])
    ->name('about');
Route::get('about/producers', [StaticPageController::class, 'showAboutProducers'])
    ->name('about.producers');
Route::get('about/crew', [StaticPageController::class, 'showAboutCrew'])
    ->name('about.crew');
Route::get('terms-and-conditions', [StaticPageController::class, 'showTermsAndConditions'])
    ->name('termsandconditions');

Route::get('signup', [UserSignupController::class, 'show'])
    ->name('signup');
Route::post('signup', [UserSignupController::class, 'signup'])
    ->name('signup');
Route::get('verify/email/{code}', [VerifyEmailController::class, 'verify'])
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
    Route::get('/account/change/producer', [AccountChangeController::class, 'producer'])
        ->name('account.change-to.producer')
        ->middleware('role:Crew');
    Route::get('/account/change/crew', [AccountChangeController::class, 'crew'])
        ->name('account.change-to.crew')
        ->middleware('role:Producer');
    Route::get('change/crew', [AccountChangeController::class, 'crew'])
        ->name('account.change-to.crew')
        ->middleware('role:Producer');
    Route::get('change/producer', [AccountChangeController::class, 'producer'])
        ->name('account.change-to.producer')
        ->middleware('role:Crew');

    Route::get('/account/close', [AccountCloseController::class, 'index'])
        ->name('account.close');
    Route::put('/account/close', [AccountCloseController::class, 'destroy']);

    Route::get('/account/contact', [AccountContactController::class, 'index'])
        ->name('account.contact');
    Route::post('/account/contact', [AccountContactController::class, 'store']);

    Route::get('/account/manager', [AccountManagerController::class, 'index'])
        ->name('account.manager');
    Route::post('/account/manager', [AccountManagerController::class, 'store']);
    Route::delete('/account/manager/{manager}/remove', [AccountManagerController::class, 'destroy'])
        ->name('manager.remove');

    Route::get('/account/name', [AccountNameController::class, 'index'])
        ->name('account.name');
    Route::post('/account/name', [AccountNameController::class, 'store']);

    Route::get('/account/notifications', [AccountNotificationController::class, 'index'])
        ->name('account.notifications');
    Route::post('/account/notifications', [AccountNotificationController::class, 'store']);

    Route::get('/account/password', [AccountPasswordController::class, 'index'])
        ->name('account.password');
    Route::post('/account/password', [AccountPasswordController::class, 'store']);

    Route::get('subscription', [AccountSubscriptionController::class, 'index'])
        ->name('account.subscription');
    Route::post('subscription', [AccountSubscriptionController::class, 'store'])
        ->name('account.subscription.subscribe');
    Route::get('user/invoice/{invoice}', [AccountSubscriptionController::class, 'show'])
        ->name('account.subscription.invoice');
    Route::get('resume', [AccountSubscriptionController::class, 'update'])
        ->name('account.subscription.resume');
    Route::get('unsubscribe', [AccountSubscriptionController::class, 'destroy'])
        ->name('account.subscription.unsubscribe');

    Route::get('/crew/profile', [CrewProfileController::class, 'index'])
        ->name('crew.profile.index');
    Route::get('crew/profile/create', [CrewProfileController::class, 'create'])
        ->name('crew.profile.create');
    Route::get('/users/{user}/crew/profile', [CrewProfileController::class, 'show'])
        ->name('crew.profile.show');
    Route::get('crew/profile/edit', [CrewProfileController::class, 'edit'])
        ->name('crew.profile.edit');

    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('crew/endorsement', [EndorsementPositionController::class, 'index'])
        ->name('crew.endorsement.index');
    Route::delete('crew/endorsement/{endorsementEndorser}', [EndorsementPositionController::class, 'destroy'])
        ->name('crew.endorsement.delete');
    Route::get('crew/endorsement/positions/{position}', [EndorsementPositionController::class, 'show'])
        ->name('crew.endorsement.position.show');

    Route::get('/account/manager/{manager}/resend-confirmation', [ManagerConfirmationController::class, 'resend'])
        ->name('manager.resend-confirmation');

    Route::get('/messages', [MessageDashboardController::class, 'index'])->name('messages');

    Route::put('/pending-flag-messages/{pendingFlagMessage}', [PendingFlagMessageController::class, 'update'])
        ->name('pending-flag-messages.update');
    Route::post('/pending-flag-messages', [PendingFlagMessageController::class, 'store'])
        ->name('pending-flag-messages.store');

    Route::get('projects/{project}/jobs/{job}/submissions', [SubmissionController::class, 'show'])
        ->middleware('role:Admin|Producer')->name('project.job.submissions.show');
});

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