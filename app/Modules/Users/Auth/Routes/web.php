<?php

declare(strict_types = 1);

use App\Modules\Users\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::get('/login', [AuthController::class, 'getLogin'])->name('auth.get.login'); // تحديد الاسم بشكل واضح
    Route::post('/login', [AuthController::class, 'postLogin'])->name('auth.post.login');

    Route::get('/forgot-password', [AuthController::class, 'getForgotPassword'])->name('auth.get.resetPassword');
    Route::post('/forgot-password', [AuthController::class, 'postForgotPassword'])->name('auth.post.resetPassword');
});
