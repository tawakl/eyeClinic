<?php

declare(strict_types = 1);

use App\Modules\Users\Controllers\Api\ProfileApiController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'auth', 'as' => 'auth.'],
    function () {
        require base_path('app/Modules/Users/Auth/Routes/api.php');
    }
);
Route::group(
    ['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth:api']],
    function () {
        Route::get('/', [ProfileApiController::class, 'getProfile'])->middleware(['auth:api', 'throttle:40000,60'])->name('getProfile');
        Route::post('/update-profile', [ProfileApiController::class, 'postUpdateProfile'])->name('updateProfile');
        Route::post('/update-password', [ProfileApiController::class, 'postUpdatePassword'])->name('updatePassword');
        Route::delete('/delete-profile', [ProfileApiController::class, 'deleteProfile'])->name('deleteProfile');
    }
);
