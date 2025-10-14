<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Route;
use App\Modules\Gallery\Admin\Controllers\GalleryController;

Route::group(
    ['prefix' => 'gallery', 'as' => 'gallery.'],
    function () {

        Route::get('/', [GalleryController::class, 'index'])->name('index');
        Route::get('/create', [GalleryController::class, 'create'])->name('create');
        Route::post('/', [GalleryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [GalleryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [GalleryController::class, 'update'])->name('update');
        Route::delete('/{id}', [GalleryController::class, 'destroy'])->name('destroy');
    }
);
