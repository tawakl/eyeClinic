<?php

declare(strict_types = 1);

namespace App\Modules\Users\Auth\Requests\api;

use App\Modules\BaseApp\Api\Requests\BaseApiParserRequest;
use App\Modules\Users\UserEnums;
use Illuminate\Validation\Rule;

class UserRegisterRequest extends BaseApiParserRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'attributes.profile_picture' => 'nullable',
            'attributes.first_name' => 'required',
            'attributes.last_name' => 'required',
            'attributes.email' => [
                'sometimes',
                'unique:users,email',
                'email'
            ],
            'attributes.mobile' => [
                'required',
                'regex:' . UserEnums::USER_MOBILE_REGEX,
                'unique:users,mobile',
            ],
            'attributes.password' => 'required|confirmed|min:8',
            'attributes.password_confirmation' => 'required|min:8',
        ];
    }
}
