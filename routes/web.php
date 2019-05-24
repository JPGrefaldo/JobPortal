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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Manager\ManagerConfirmationController;
use App\Http\Controllers\PendingFlagMessageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StaticPageController;
use App\Http\Controllers\User\UserSettingsController;
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

Route::get('/', [IndexController::class, 'index'])
    ->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login');
Route::post('login', [LoginController::class, 'login'])
    ->name('login.post');

Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');

Route::get('signup', [UserSignupController::class, 'show'])
    ->name('signup');
Route::post('signup', [UserSignupController::class, 'signup']);

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

Route::get('verify/email/{code}', [VerifyEmailController::class, 'verify'])
    ->name('verify.email');

Route::get('confirm/{user}/{subordinate}', [ManagerConfirmationController::class, 'index'])
    ->name('manager.confirm');

Route::get('terms-and-conditions', [StaticPageController::class, 'showTermsAndConditions'])
    ->name('termsandconditions');

Route::get('about', [StaticPageController::class, 'showAbout'])
    ->name('about');

Route::get('about/producers', [StaticPageController::class, 'showAboutProducers'])
    ->name('about.producers');

Route::get('about/crew', [StaticPageController::class, 'showAboutCrew'])
    ->name('about.crew');

Route::get('current-projects', [ProjectController::class, 'showCurrentProjects'])
    ->name('projects.current-projects');
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| User must be logged in
|
*/
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/messages', ['as' => 'messages', 'uses' => 'MessageDashboardController@index']);

    Route::prefix('account')->group(function () {
        Route::get('name', [AccountNameController::class, 'index'])
            ->name('account.name');
        Route::post('name', [AccountNameController::class, 'store']);

        Route::get('contact', [AccountContactController::class, 'index'])
            ->name('account.contact');
        Route::post('contact', [AccountContactController::class, 'store']);

        Route::get('subscription', [AccountSubscriptionController::class, 'index'])
            ->name('account.subscription');
        Route::post('subscription', [AccountSubscriptionController::class, 'store'])
            ->name('account.subscription.subscribe');
        Route::get('unsubscribe', [AccountSubscriptionController::class, 'destroy'])
            ->name('account.subscription.unsubscribe');
        Route::get('resume', [AccountSubscriptionController::class, 'update'])
            ->name('account.subscription.resume');
        Route::get('user/invoice/{invoice}', [AccountSubscriptionController::class, 'show'])
            ->name('account.subscription.invoice');

        Route::get('password', [AccountPasswordController::class, 'index'])
            ->name('account.password');
        Route::post('password', [AccountPasswordController::class, 'store']);

        Route::get('manager', [AccountManagerController::class, 'index'])
            ->name('account.manager');
        Route::post('manager', [AccountManagerController::class, 'store']);
        Route::delete('manager/{manager}/remove', [AccountManagerController::class, 'destroy'])
            ->name('manager.remove');
        Route::get('manager/{manager}/resend-confirmation', [ManagerConfirmationController::class, 'resend'])
            ->name('manager.resend-confirmation');

        Route::get('notifications', [AccountNotificationController::class, 'index'])
            ->name('account.notifications');
        Route::post('notifications', [AccountNotificationController::class, 'store']);

        Route::get('close', [AccountCloseController::class, 'index'])
            ->name('account.close');
        Route::put('close', [AccountCloseController::class, 'destroy']);

        Route::put('settings/name', [UserSettingsController::class, 'updateName']);
        Route::put('settings/notifications', [UserSettingsController::class, 'updateNotifications']);
        Route::put('settings/password', [UserSettingsController::class, 'updatePassword']);

        Route::get('change/crew', [AccountChangeController::class, 'crew'])
            ->name('account.change-to.crew')
            ->middleware('role:Producer');

        Route::get('change/producer', [AccountChangeController::class, 'producer'])
            ->name('account.change-to.producer')
            ->middleware('role:Crew');
    });

    Route::post('/pending-flag-messages', [PendingFlagMessageController::class, 'store'])
        ->name('pending-flag-messages.store');

    Route::put('/pending-flag-messages/{pendingFlagMessage}', [PendingFlagMessageController::class, 'update'])
        ->name('pending-flag-messages.update');

    Route::middleware('role:Admin')
        ->namespace('App\Http\Controllers\Admin')
        ->group(base_path('routes/admin.php'));

    Route::middleware('role:Crew')
        ->namespace('App\Http\Controllers\Crew')
        ->group(base_path('routes/crew.php'));

    Route::middleware('role:Producer')
        ->namespace('App\Http\Controllers\Producer')
        ->group(base_path('routes/producer.php'));

    Route::get('projects/{project}/jobs/{job}/submissions', [
        \App\Http\Controllers\SubmissionController::class,
        'show',
    ])->middleware('role:Admin|Producer')->name('project.job.submissions.show');

    Route::get('/users/{user}/crew/profile', [CrewProfileController::class, 'show'])->name('crew.profile.show');
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
