<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\PendingFlagMessageController;

Route::put('/admin/users/ban/{user}', [AdminUserController::class, 'updateBan'])
    ->name('admin.users.ban');

Route::prefix('/admin/sites')->group(function () {
    Route::get('/', [SiteController::class, 'index'])
        ->name('admin.sites');
});

Route::prefix('/admin/departments')->group(function () {
    Route::get('/', [DepartmentController::class, 'index'])
        ->name('admin.departments');
    Route::post('/', [DepartmentController::class, 'store']);
    Route::put('/{department}', [DepartmentController::class, 'update'])
        ->name('admin.departments.update');
});

Route::prefix('/admin/positions')->group(function () {
    Route::get('/', [PositionController::class, 'index'])
        ->name('admin.positions');
    Route::post('/', [PositionController::class, 'store']);
    Route::put('/{position}', [PositionController::class, 'update'])
        ->name('admin.positions.update');
});

Route::prefix('/admin/projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])
        ->name('admin.projects');
    Route::put('/{project}/approve', [ProjectController::class, 'approve'])
        ->name('admin.projects.approve');
    Route::put('/{project}/unapprove', [ProjectController::class, 'unapprove'])
        ->name('admin.projects.unapprove');
    Route::put('/{project}', [ProjectController::class, 'update'])
        ->name('admin.projects.update');
    Route::get('/pending', [ProjectController::class, 'unApprovedProjects'])
        ->name('admin.pending-projects');
});

Route::get('/admin/flag-messages', [PendingFlagMessageController::class, 'index'])
    ->middleware('role:Admin')->name('admin.messages.flagged.index');
