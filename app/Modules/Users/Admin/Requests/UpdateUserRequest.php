<?php

declare(strict_types = 1);

namespace App\Modules\Users\Admin\Requests;

use App\Modules\BaseApp\Requests\BaseAppRequest;
use App\Modules\GarbageMedia\Enums\GarbageMediaEnum;
use App\Modules\Users\UserEnums;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends BaseAppRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = $this->route('id');
        return [
            'first_name' => 'required|min:3|max:190|regex:' . UserEnums::USER_NAME_REGEX,
            'last_name' => 'required|min:3|max:190|regex:' . UserEnums::USER_NAME_REGEX,
            'email' => [
                'nullable',
                Rule::unique('users')->ignore($userId)->where(
                    function ($query) {
                        return $query->where('deleted_at', null);
                    }
                ),
                'email'
            ],
            'mobile' => [
                'required',
                'regex:' . UserEnums::USER_MOBILE_REGEX,
                Rule::unique('users')->ignore($userId)->where(
                    function ($query) {
                        return $query->where('deleted_at', null);
                    }
                ),
            ],
            'password' => 'nullable|min:8|confirmed',
            'is_active' => ['required', 'boolean'],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:' . GarbageMediaEnum::UPLOAD_IMAGE_MAX_SIZE,
        ];
    }
}
