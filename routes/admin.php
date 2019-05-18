<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\PendingFlagMessageController;

Route::put('/admin/users/ban/{user}', [AdminUserController::class, 'updateBan'])
    ->name('admin.users.ban');

Route::get('/admin/sites', [SiteController::class, 'index'])
    ->name('admin.sites');

Route::get('/admin/departments', [DepartmentController::class, 'index'])
    ->name('admin.departments');
Route::post('/admin/departments', [DepartmentController::class, 'store']);
Route::put('/admin/departments/{department}', [DepartmentController::class, 'update'])
    ->name('admin.departments.update');


Route::get('/admin/positions', [PositionController::class, 'index'])
    ->name('admin.positions');
Route::post('/admin/positions', [PositionController::class, 'store']);
Route::put('/admin/positions/{position}', [PositionController::class, 'update'])
    ->name('admin.positions.update');


Route::get('/admin/projects', [ProjectController::class, 'index'])
    ->name('admin.projects');
Route::put('/admin/projects/{project}/approve', [ProjectController::class, 'approve'])
    ->name('admin.projects.approve');
Route::put('/admin/projects/{project}/unapprove', [ProjectController::class, 'unapprove'])
    ->name('admin.projects.unapprove');
Route::put('/admin/projects/{project}', [ProjectController::class, 'update'])
    ->name('admin.projects.update');
Route::get('/admin/projects/pending', [ProjectController::class, 'unApprovedProjects'])
    ->name('admin.pending-projects');

Route::get('/admin/flag-messages', [PendingFlagMessageController::class, 'index'])
    ->middleware('role:Admin')->name('admin.messages.flagged.index');
