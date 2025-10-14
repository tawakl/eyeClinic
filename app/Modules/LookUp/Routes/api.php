<?php

declare(strict_types = 1);

use App\Modules\LookUp\Controllers\Api\LookUpController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'look-up', 'as' => 'lookUp.'],
    function () {

        Route::get('/', [LookUpController::class, 'getIndex'])->name('get.index');
    }
);
