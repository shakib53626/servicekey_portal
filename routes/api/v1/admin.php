<?php

use App\Http\Controllers\Api\Admin\AdminAuthController;
use App\Http\Controllers\Api\Admin\PermissionController;
use App\Http\Controllers\Api\Admin\RoleController;
use Illuminate\Support\Facades\Route;



Route::controller(AdminAuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/reset-password', 'resetPassword');
});

Route::middleware('auth:admin-api')->group(function () {

    Route::controller(AdminAuthController::class)->group(function () {
        Route::post('/logout', 'logout');
        Route::post('/change-password', 'changePassword');
        Route::get('/reset-password-request-list', 'resetPasswordRequestList');
        Route::post('/reset-password-approve', 'resetPasswordApproval');
        Route::get('/me',  'user');
    });

    Route::controller(PermissionController::class)->group(function () {
        Route::get('/permissions', 'index');
        Route::get('/permissions/group', 'groupByData');
        Route::post('/permissions', 'store');
        Route::get('/permissions/{id}', 'show');
        Route::put('/permissions/{id}', 'update');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::post('/roles', 'store');
    });
});
