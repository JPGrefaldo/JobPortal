<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\PendingFlagMessageController;

// api
Route::put('/admin/users/ban/{user}', [AdminUserController::class, 'updateBan'])
    ->name('admin.users.ban');

// web
Route::get('/admin/flag-messages', [PendingFlagMessageController::class, 'index'])
    ->middleware('role:Admin')->name('admin.messages.flagged.index');

// api
Route::get('/admin/positions', [PositionController::class, 'index'])
    ->name('admin.positions');
// api
Route::post('/admin/positions', [PositionController::class, 'store']);
// api
Route::put('/admin/positions/{position}', [PositionController::class, 'update'])
    ->name('admin.positions.update');

// web
Route::get('/admin/projects', [ProjectController::class, 'index'])
    ->name('admin.projects');

// api
Route::get('/admin/sites', [SiteController::class, 'index'])
    ->name('admin.sites');
