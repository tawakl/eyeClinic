<?php

declare(strict_types = 1);

use App\Modules\Users\User;
use Illuminate\Support\Facades\Route;

Route::group(
    ['as' => 'api.'],
    function () {
        require base_path('app/Modules/Users/Routes/api.php');
        require base_path('app/Modules/LandingPage/Routes/api.php');


    }
);
Route::get(
    'server-health-check',
    function () {
        return response()->json(
            [
            'message' => 'Server is up and running.'
            ],
            200
        );
    }
);
