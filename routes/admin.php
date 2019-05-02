<?php

Route::put('/admin/users/ban/{user}', [\App\Http\Controllers\Admin\AdminUsersController::class, 'updateBan'])
    ->name('admin.users.ban');

Route::prefix('/admin/sites')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\SiteController::class, 'index'])
        ->name('admin.sites');
});

Route::prefix('/admin/departments')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DepartmentsController::class, 'index'])
        ->name('admin.departments');
    Route::post('/', [\App\Http\Controllers\Admin\DepartmentsController::class, 'store']);
    Route::put('/{department}', [\App\Http\Controllers\Admin\DepartmentsController::class, 'update'])
        ->name('admin.departments.update');
});

Route::prefix('/admin/positions')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\PositionsController::class, 'index'])
        ->name('admin.positions');
    Route::post('/', [\App\Http\Controllers\Admin\PositionsController::class, 'store']);
    Route::put('/{position}', [\App\Http\Controllers\Admin\PositionsController::class, 'update'])
        ->name('admin.positions.update');
});

Route::prefix('/admin/projects')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\ProjectController::class, 'index'])
        ->name('admin.projects');
    Route::put('/{project}/approve', [\App\Http\Controllers\Admin\ProjectController::class, 'approve'])
        ->name('admin.projects.approve');
    Route::put('/{project}/unapprove', [\App\Http\Controllers\Admin\ProjectController::class, 'unapprove'])
        ->name('admin.projects.unapprove');
    Route::put('/{project}', [\App\Http\Controllers\Admin\ProjectController::class, 'update'])
        ->name('admin.projects.update');
});

Route::get('/admin/flag-messages', [\App\Http\Controllers\PendingFlagMessageController::class, 'index'])
    ->middleware('role:Admin')->name('admin.messages.flagged.index');
