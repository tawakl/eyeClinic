<?php

declare(strict_types = 1);

use App\Modules\Users\Admin\Controllers\AjaxUsersController;
use App\Modules\Users\Admin\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Modules\Users\Admin\Controllers\UserController;

Route::group(
    ['prefix' => 'users', 'as' => 'users.'],
    function () {
        Route::get('/', [UserController::class, 'getIndex'])->name('get.index');
        Route::get('/create', [UserController::class, 'getCreate'])->name('get.create');
        Route::post('/create', [UserController::class, 'postCreate'])->name('post.create');
        Route::get('/edit/{id}', [UserController::class, 'getEdit'])->name('get.edit');
        Route::post('/edit/{id}', [UserController::class, 'postEdit'])->name('post.edit');
    }
);

Route::group(
    ['prefix' => 'profile', 'as' => 'profile.'],
    function () {
        Route::get('edit/', [ProfileController::class, 'getEdit'])->name('get.edit');
        Route::put('edit/', [ProfileController::class, 'postEdit'])->name('post.edit');
        Route::get('logout/', [ProfileController::class, 'getLogout'])->name('get.logout');
    }
);
