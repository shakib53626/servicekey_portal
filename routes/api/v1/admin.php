<?php

use App\Http\Controllers\Api\Admin\AdminAuthController;
use App\Http\Controllers\Api\Admin\PermissionController;
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
        Route::post('/permissions', 'store');
    });
});
