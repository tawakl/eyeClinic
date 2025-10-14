<?php

declare(strict_types = 1);

namespace App\Modules\Users\Auth\Enum;


use App\Modules\BaseApp\Enums\DynamicLinksEnum;
use App\Modules\Notifications\Enums\NotificationEnum;
use App\Modules\Users\UserEnums;

class ResetPasswordEnum
{
    private $url;
    public $types;

    public function __construct(
        private $token
    ) {
        $this->url = '{firebase_url}/?link={portal_url}/dynamic-link%3F{query_param}&apn=com.ouredu.students';
        $this->types = [
            UserEnums::SUPER_ADMIN_TYPE => env('FIREBASE_URL_PREFIX') . '/?link=' . env(
                    'ADMIN  _PORTAL_URL'
                ) . '/auth/update-password%3Ftoken%3D' . $this->token . '%26notification_type%3D' . NotificationEnum::FORGOT_PASSWORD . '&apn=com.ouredu.students',
            UserEnums::INSTRUCTOR_TYPE => env('STUDENT_PORTAL_URL') . '/auth/reset-password/' . $this->token,
        ];
    }

    public function getTypeLink(string $type)
    {
        if ($type != UserEnums::SUPER_ADMIN_TYPE) {
            return getDynamicLink(
                DynamicLinksEnum::DYNAMIC_URL_PATTERN,
                [
                    'portal_url' => env('STUDENT_PORTAL_URL'),
                    'query_param' => 'token=' . $this->token . '&target_screen=' . DynamicLinksEnum::RESET_PASSWORD,
                    'android_apn' => env('ANDROID_APN')
                ]
            );
        }
        // even if user has no firebase tokens, will be redirected to appstore
        return $this->types[$type];
    }
}
