<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'admin','as' => 'admin.'],
    function () {
        require base_path('app/Modules/Dashboard/Admin/Routes/web.php');
    }
);
