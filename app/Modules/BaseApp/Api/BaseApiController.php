<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Api;

use App\Http\Controllers\Controller;
use App\Modules\BaseApp\Api\Traits\ApiResponser;

class BaseApiController extends Controller
{
    use ApiResponser;
}
