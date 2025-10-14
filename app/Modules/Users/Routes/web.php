<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'auth', 'as' => 'auth.'],
    function () {
        require base_path('app/Modules/Users/Auth/Routes/web.php');
    }
);
