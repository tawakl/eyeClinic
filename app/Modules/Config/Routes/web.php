<?php

use App\Modules\Config\Admin\Controllers\ConfigsController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'configs', 'as' => 'configs.'],
    function () {
        Route::get('/edit', [ConfigsController::class,'getEdit'])->name('get.edit');
        Route::put('/edit', [ConfigsController::class,'postEdit'])->name('post.edit');
    }
);
