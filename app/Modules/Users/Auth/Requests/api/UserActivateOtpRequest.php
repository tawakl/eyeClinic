<?php

declare(strict_types = 1);

namespace App\Modules\Users\Auth\Requests\api;

use App\Modules\BaseApp\Api\Requests\BaseApiParserRequest;

class UserActivateOtpRequest extends BaseApiParserRequest
{
    public function rules()
    {
        return [
            'attributes.otp' => 'required',
        ];
    }
}
