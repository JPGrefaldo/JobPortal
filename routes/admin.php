<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\PendingFlagMessageController;

Route::put('/admin/users/ban/{user}', [AdminUserController::class, 'updateBan'])
    ->name('admin.users.ban');

Route::get('/admin/flag-messages', [PendingFlagMessageController::class, 'index'])
    ->middleware('role:Admin')->name('admin.messages.flagged.index');

Route::get('/admin/positions', [PositionController::class, 'index'])
    ->name('admin.positions');
Route::post('/admin/positions', [PositionController::class, 'store']);
Route::put('/admin/positions/{position}', [PositionController::class, 'update'])
    ->name('admin.positions.update');

Route::get('/admin/projects', [ProjectController::class, 'index'])
    ->name('admin.projects');

Route::get('/admin/sites', [SiteController::class, 'index'])
    ->name('admin.sites');
