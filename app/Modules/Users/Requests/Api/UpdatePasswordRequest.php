<?php

declare(strict_types = 1);

namespace App\Modules\Users\Requests\Api;

use App\Modules\BaseApp\Api\Requests\BaseApiParserRequest;

class UpdatePasswordRequest extends BaseApiParserRequest
{
    public function rules()
    {
        $rules['attributes.old_password'] = 'nullable';
        $rules['attributes.password'] = 'required|min:8|confirmed';

        return $rules;
    }
}
