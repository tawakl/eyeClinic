<?php

declare(strict_types = 1);

namespace App\Modules\Users\Auth\Requests\api;

use App\Modules\BaseApp\Api\Requests\BaseApiParserRequest;
use App\Modules\Users\UserEnums;

class ReactivateProfileRequest extends BaseApiParserRequest
{
    public function rules()
    {
        return [
            'attributes.mobile' => [
                'required',
                'regex:' . UserEnums::USER_MOBILE_REGEX
            ],
        ];
    }
}
