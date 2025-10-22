<?php

use App\Modules\Publications\Admin\Controllers\PublicationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'publication', 'as' => 'publication.'], function () {
    Route::get('/', [PublicationController::class, 'index'])->name('index');
    Route::get('/create', [PublicationController::class, 'create'])->name('create');
    Route::post('/create', [PublicationController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [PublicationController::class, 'edit'])->name('edit');
    Route::put('/edit/{id}', [PublicationController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [PublicationController::class, 'destroy'])->name('destroy');
});
