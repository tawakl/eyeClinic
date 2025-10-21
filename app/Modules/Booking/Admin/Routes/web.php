<?php

declare(strict_types = 1);

use App\Modules\Booking\Admin\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('index');
    Route::post('/{id}/status/{status}', [BookingController::class, 'updateStatus'])->name('updateStatus');
    Route::delete('/{id}', [BookingController::class, 'destroy'])->name('destroy');
});

