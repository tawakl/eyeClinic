<?php

declare(strict_types = 1);

use App\Modules\Users\Auth\Controllers\Api\AuthApiController;
use App\Modules\Users\Auth\Controllers\Api\PasswordResetApiController;
use Illuminate\Support\Facades\Route;
Route::post('/login', [AuthApiController::class, 'postLogin'])->name('post.login');
Route::post('/register', [AuthApiController::class,'postRegister'])->name('post.register');
//Route::post('/activate-otp', [AuthApiController::class,'getActivateOtp'])->name('post.activateOtp');
//Route::post('/resend-otp-confirm', [AuthApiController::class,'resendOtpConfirm'])->name('post.resendOtpConfirm');
//Route::post('reactivate-profile', [AuthApiController::class, 'reactivateProfile']);
Route::post('/logout', [AuthApiController::class, 'postLogout'])->name('post.logout')->middleware('auth:api');





Route::group(
    ['prefix' => 'reset-password', 'as' => 'resetPassword'],
    function () {
        Route::post('/send-code', [PasswordResetApiController::class, 'sendCode'])
        ->name('send-code');
        Route::post('/confirm-code', [PasswordResetApiController::class, 'confirmCode'])
        ->name('confirm-code');
        Route::post('/{token}', [PasswordResetApiController::class, 'resetUserPassword']);
    }
);
