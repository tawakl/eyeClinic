<?php

use App\Modules\WorkingHours\Admin\Controllers\ClinicClosingPeriodsController;
use App\Modules\WorkingHours\Admin\Controllers\ClinicWorkingDaysController;
use Illuminate\Support\Facades\Route;

Route::prefix('clinic-working-days')->name('clinicWorkingDays.')->group(function () {
    Route::get('/', [ClinicWorkingDaysController::class, 'index'])->name('index');
    Route::post('/update', [ClinicWorkingDaysController::class, 'update'])->name('update');
});


Route::prefix('clinic-closing-periods')->name('clinicClosingPeriods.')->group(function () {
    Route::get('/edit', [ClinicClosingPeriodsController::class, 'edit'])->name('edit');
    Route::put('/update', [ClinicClosingPeriodsController::class, 'update'])->name('update');

});
