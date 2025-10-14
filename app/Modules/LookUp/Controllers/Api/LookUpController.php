<?php

declare(strict_types = 1);

namespace App\Modules\LookUp\Controllers\Api;

use App\Modules\BaseApp\Api\BaseApiController;
use App\Modules\BaseApp\Enums\ResourceTypesEnums;
use App\Modules\LookUp\Transformers\LookUpTransformer;
use Illuminate\Http\Request;

class LookUpController extends BaseApiController
{
    public function __construct()
    {
    }

    public function getIndex(Request $request)
    {
        $data = ['dum'=>'data'];

        $include = $request->get('include') ?? '';
        $param = $request->get('filter') ?? [];
        $param['user'] = auth()->guard('api')->user() ?? null;
        return $this->transformDataModInclude(
            $data,
            $include,
            new LookUpTransformer($param),
            ResourceTypesEnums::LOOKUP
        );
    }
}
