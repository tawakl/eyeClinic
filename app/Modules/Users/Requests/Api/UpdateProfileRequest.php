<?php

declare(strict_types = 1);

namespace App\Modules\Users\Requests\Api;

use App\Modules\BaseApp\Api\Requests\BaseApiParserRequest;
use App\Modules\Users\User;
use App\Modules\Users\UserEnums;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends BaseApiParserRequest
{
    public function rules()
    {
        $user = User::findOrFail(auth('api')->id());
        $array = [];
        $array['attributes.first_name'] = 'required|max:190';
        $array['attributes.last_name'] = 'required|max:190';
        $array['attributes.profile_picture'] = 'nullable|integer|exists:garbage_media,id';
            $array['attributes.mobile'] = [
                'required',
                'regex:'.UserEnums::USER_MOBILE_REGEX,
                Rule::unique('users', 'mobile')->where(
                    function ($query) {
                        return $query->where('deleted_at', null);
                    }
                )->ignore(auth('api')->id()),
            ];

            $array['attributes.email'] = [
            'sometimes',
            'email',
            Rule::unique('users', 'email')->where(
                function ($query) {
                    return $query->where('deleted_at', null);
                }
            )->ignore(auth('api')->id())
            ];
            return $array;
    }
}
