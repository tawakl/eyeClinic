<?php

declare(strict_types = 1);

use App\Modules\GarbageMedia\Controllers\Api\GarbageMediaController;
use App\Modules\GarbageMedia\Controllers\Api\MediaController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'media'],
    function () {
        Route::post('/', [GarbageMediaController::class, 'postMedia']);
    }
);
