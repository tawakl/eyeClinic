<?php

declare(strict_types = 1);

namespace App\Modules\Users\Admin\Requests;

use App\Modules\BaseApp\Requests\BaseAppRequest;
use App\Modules\GarbageMedia\Enums\GarbageMediaEnum;
use App\Modules\Users\User;
use App\Modules\Users\UserEnums;
use Illuminate\Validation\Rule;

class CreateUserRequest extends BaseAppRequest
{


    private $user;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|min:3|regex:' . UserEnums::USER_NAME_REGEX,
            'last_name' => 'required|min:3|regex:' . UserEnums::USER_NAME_REGEX,
            'email' => [
                'nullable',
                Rule::unique('users')->where(
                    function ($query) {
                        return $query->where('deleted_at', null);
                    }
                ),
                'email'
            ],
            'mobile' => [
                'required',
                'regex:' . UserEnums::USER_MOBILE_REGEX,
                Rule::unique('users')->where(
                    function ($query) {
                        return $query->where('deleted_at', null);
                    }
                ),
            ],
            'is_active' => 'required|boolean',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:' . GarbageMediaEnum::UPLOAD_IMAGE_MAX_SIZE,
            'type' => 'required|string|in:' . implode(',', array_keys(UserEnums::filterableUserType())),
        ];
    }
}
