<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Modules\Users\Auth\Controllers\AuthController;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
            Route::get('/login', [AuthController::class, 'getLogin'])->name('get.login');
            Route::post('/login', [AuthController::class, 'postLogin'])->name('post.login');

            Route::get('/forgot-password', [AuthController::class, 'getForgotPassword'])->name('get.resetPassword');
            Route::post('/forgot-password', [AuthController::class, 'postForgotPassword'])->name('post.resetPassword');
        });

        Route::group(
            ['middleware' => ['auth', 'suspended'], 'prefix' => 'admin', 'as' => 'admin.'],
            function () {
                require base_path('app/Modules/Dashboard/Admin/Routes/web.php');
                require base_path('app/Modules/Users/Admin/Routes/web.php');
                require base_path('app/Modules/Gallery/Admin/Routes/web.php');

//                require base_path('app/Modules/Contact/Admin/Routes/web.php');

            }
        );
    }
);
