<?php

declare(strict_types = 1);

namespace App\Modules\Users\Auth\Requests\api;

use App\Modules\BaseApp\Api\Requests\BaseApiParserRequest;

class SendResetPasswordCodeRequest extends BaseApiParserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'attributes.identifier' => ['required']
        ];
    }
}
