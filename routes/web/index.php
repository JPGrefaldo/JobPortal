<?php

use App\Http\Controllers\Account\AccountChangeController;
use App\Http\Controllers\Account\AccountCloseController;
use App\Http\Controllers\Account\AccountContactController;
use App\Http\Controllers\Account\AccountManagerController;
use App\Http\Controllers\Account\AccountNameController;
use App\Http\Controllers\Account\AccountNotificationController;
use App\Http\Controllers\Account\AccountPasswordController;
use App\Http\Controllers\Account\AccountSubscriptionController;
use App\Http\Controllers\Crew\CrewProfileController;
use App\Http\Controllers\Crew\Endorsements\EndorsementPositionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Manager\ManagerConfirmationController;
use App\Http\Controllers\MessageDashboardController;
use App\Http\Controllers\PendingFlagMessageController;
use App\Http\Controllers\SubmissionController;

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
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| User must be logged in
|
*/
Route::get('/account/change/producer', [AccountChangeController::class, 'producer'])->name('account.change-to.producer')->middleware('role:Crew');
Route::get('/account/change/crew', [AccountChangeController::class, 'crew'])->name('account.change-to.crew')->middleware('role:Producer');
Route::get('change/crew', [AccountChangeController::class, 'crew'])->name('account.change-to.crew')->middleware('role:Producer');
Route::get('change/producer', [AccountChangeController::class, 'producer'])->name('account.change-to.producer')->middleware('role:Crew');

Route::get('/account/close', [AccountCloseController::class, 'index'])->name('account.close');
Route::put('/account/close', [AccountCloseController::class, 'destroy']);

Route::get('/account/contact', [AccountContactController::class, 'index'])->name('account.contact');
Route::post('/account/contact', [AccountContactController::class, 'store']);

Route::get('/account/manager', [AccountManagerController::class, 'index'])->name('account.manager');
Route::post('/account/manager', [AccountManagerController::class, 'store']);
Route::delete('/account/manager/{manager}/remove', [AccountManagerController::class, 'destroy'])->name('manager.remove');

Route::get('/account/name', [AccountNameController::class, 'index'])->name('account.name');
Route::post('/account/name', [AccountNameController::class, 'store']);

Route::get('/account/notifications', [AccountNotificationController::class, 'index'])->name('account.notifications');
Route::post('/account/notifications', [AccountNotificationController::class, 'store']);

Route::get('/account/password', [AccountPasswordController::class, 'index'])->name('account.password');
Route::post('/account/password', [AccountPasswordController::class, 'store']);

Route::get('subscription', [AccountSubscriptionController::class, 'index'])->name('account.subscription');
Route::post('subscription', [AccountSubscriptionController::class, 'store'])->name('account.subscription.subscribe');
Route::get('user/invoice/{invoice}', [AccountSubscriptionController::class, 'show'])->name('account.subscription.invoice');
Route::get('resume', [AccountSubscriptionController::class, 'update'])->name('account.subscription.resume');
Route::get('unsubscribe', [AccountSubscriptionController::class, 'destroy'])->name('account.subscription.unsubscribe');

Route::get('/crew/profile', [CrewProfileController::class, 'index'])->name('crew.profile.index');
Route::get('crew/profile/create', [CrewProfileController::class, 'create'])->name('crew.profile.create');
Route::get('/users/{user}/crew/profile', [CrewProfileController::class, 'show'])->name('crew.profile.show');
Route::get('crew/profile/edit', [CrewProfileController::class, 'edit'])->name('crew.profile.edit');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('crew/endorsement', [EndorsementPositionController::class, 'index'])->name('crew.endorsement.index');
Route::delete('crew/endorsement/{endorsementEndorser}', [EndorsementPositionController::class, 'destroy'])->name('crew.endorsement.delete');
Route::get('crew/endorsement/positions/{position}', [EndorsementPositionController::class, 'show'])->name('crew.endorsement.position.show');

Route::get('/account/manager/{manager}/resend-confirmation', [ManagerConfirmationController::class, 'resend'])->name('manager.resend-confirmation');

Route::get('/messages', [MessageDashboardController::class, 'index'])->name('messages');

Route::put('/pending-flag-messages/{pendingFlagMessage}', [PendingFlagMessageController::class, 'update'])->name('pending-flag-messages.update');
Route::post('/pending-flag-messages', [PendingFlagMessageController::class, 'store'])->name('pending-flag-messages.store');

Route::get('projects/{project}/jobs/{job}/submissions', [SubmissionController::class, 'show'])->middleware('role:Admin|Producer')->name('project.job.submissions.show');
