<?php

use App\Modules\LandingPage\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'landing-page',
    ],
    function () {

        Route::get("config", [LandingPageController::class, 'getConfig'])->name("landingPage.getConfig");
        Route::get("gallery", [LandingPageController::class, 'gallery'])->name("landingPage.gallery");
        Route::get("team", [LandingPageController::class, 'team'])->name("landingPage.team");
        Route::post('booking', [LandingPageController::class, 'storeBooking'])->name('landingPage.booking.store');
        Route::get('working-hours', [LandingPageController::class, 'workingHours'])->name('landingPage.workingHours');
        Route::get('available-slots-for-day', [LandingPageController::class, 'availableSlotsForDay']);
        Route::get('publications', [LandingPageController::class, 'publications'])->name('landingPage.publications');



    }
);
