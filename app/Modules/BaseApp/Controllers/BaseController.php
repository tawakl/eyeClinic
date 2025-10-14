<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BaseApp\Api\Traits\ApiResponser;

class BaseController extends Controller
{
    use ApiResponser;
}
