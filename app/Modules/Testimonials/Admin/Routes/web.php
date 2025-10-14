<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Route;
use App\Modules\Testimonials\Admin\Controllers\TestimonialController;

Route::group(
    ['prefix' => 'testimonials', 'as' => 'testimonials.'],
    function () {

        Route::get('/', [TestimonialController::class, 'getIndex'])->name('get.index');
        Route::get('/create', [TestimonialController::class, 'getCreate'])->name('get.create');
        Route::post('/create', [TestimonialController::class, 'postCreate'])->name('post.create');
        Route::patch('/{testimonial}/toggle-status', [TestimonialController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/rating', [TestimonialController::class, 'getRating'])->name('getRating');
        Route::patch('/add-rating/{rating}', [TestimonialController::class, 'addRatingToTestimonial'])->name('addRating');
        Route::delete('/rating/{rating}', [TestimonialController::class, 'deleteRating'])->name('deleteRating');
    }
);
