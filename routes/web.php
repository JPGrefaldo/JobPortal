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

Route::get('/', [\App\Http\Controllers\IndexController::class, 'index'])
    ->name('home');

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

Route::get('confirm/{user}/{subordinate}', [\App\Http\Controllers\Manager\ManagerConfirmationController::class, 'index'])
    ->name('manager.confirm');

Route::get('terms-and-conditions', [\App\Http\Controllers\TermsAndConditionsController::class, 'show'])
    ->name('termsandconditions');
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
        Route::post('manager', [\App\Http\Controllers\Account\AccountManagerController::class, 'store']);
        Route::delete('manager/{manager}/remove', [\App\Http\Controllers\Account\AccountManagerController::class, 'destroy'])
            ->name('manager.remove');
        Route::get('manager/{manager}/resend-confirmation', [\App\Http\Controllers\Manager\ManagerConfirmationController::class, 'resend'])
            ->name('manager.resend-confirmation');

        Route::get('notifications', [\App\Http\Controllers\Account\AccountNotificationsController::class, 'index'])
            ->name('account.notifications');
        Route::post('notifications', [\App\Http\Controllers\Account\AccountNotificationsController::class, 'store']);

        Route::get('close', [\App\Http\Controllers\Account\AccountCloseController::class, 'index'])
            ->name('account.close');
        Route::put('close', [\App\Http\Controllers\Account\AccountCloseController::class, 'destroy']);

        Route::put('settings/name', [\App\Http\Controllers\User\UserSettingsController::class, 'updateName']);
        Route::put('settings/notifications', [\App\Http\Controllers\User\UserSettingsController::class, 'updateNotifications']);
        Route::put('settings/password', [\App\Http\Controllers\User\UserSettingsController::class, 'updatePassword']);

        Route::get('change/crew', [\App\Http\Controllers\Account\AccountChangeController::class, 'crew'])
            ->name('account.change-to.crew')
            ->middleware('role:Producer');

        Route::get('change/producer', [\App\Http\Controllers\Account\AccountChangeController::class, 'producer'])
            ->name('account.change-to.producer')
            ->middleware('role:Crew');
    });

    Route::post('/pending-flag-messages', [\App\Http\Controllers\PendingFlagMessageController::class, 'store'])
        ->name('pending-flag-messages.store');

    Route::put('/pending-flag-messages/{pendingFlagMessage}', [\App\Http\Controllers\PendingFlagMessageController::class, 'update'])
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
