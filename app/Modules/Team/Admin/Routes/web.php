<?php

use App\Modules\Team\Admin\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'team', 'as' => 'team.'], function () {
    Route::get('/', [TeamController::class, 'index'])->name('index');
    Route::get('/create', [TeamController::class, 'create'])->name('create');
    Route::post('/create', [TeamController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [TeamController::class, 'edit'])->name('edit');
    Route::put('/edit/{id}', [TeamController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [TeamController::class, 'destroy'])->name('destroy');
});
