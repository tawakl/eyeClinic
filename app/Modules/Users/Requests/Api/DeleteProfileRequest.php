<?php

declare(strict_types = 1);

namespace App\Modules\Users\Requests\Api;

use App\Modules\BaseApp\Api\Requests\BaseApiParserRequest;

class DeleteProfileRequest extends BaseApiParserRequest
{
    public function rules()
    {
        return [
            'attributes.old_password' => 'required'
        ];
    }
}
