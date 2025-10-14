<?php

declare(strict_types = 1);

use App\Modules\Dashboard\Admin\Controllers\DashBoardController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashBoardController::class, 'getIndex'])->name('dashboard');
