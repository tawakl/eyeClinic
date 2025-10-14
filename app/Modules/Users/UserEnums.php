<?php

declare(strict_types = 1);

namespace App\Modules\Users;

abstract class UserEnums
{
    /**
     * List of all user's type used in users table
     */
    public const
        CLIENT_TYPE = 'client',
        SUPER_ADMIN_TYPE = 'super_admin',
        ADMIN = 'admin',
        STAGING_SUPER_ADMIN_TYPE = 'staging_super_admin',
        USER_MOBILE_REGEX = "/^((009665|9665|\+9665+[^2])+([0-9]){7})|(\+201[0125][0-9]{8})+$/",
        USER_NAME_REGEX = '/^[a-zA-Z\x{0600}-\x{06FF}\s]+$/u',
        USER_LOGIN_MOBILE_TYPE = 'mobile',
        USER_LOGIN_EMAIL_TYPE = 'email',
        DEVICE_TYPE_IOS = 'ios',
        DEVICE_TYPE_ANDROID = 'android',
        NAME_MAX_LENGTH = 9;


    public static function availableUserType(): array
    {
        return [
            self::SUPER_ADMIN_TYPE => self::SUPER_ADMIN_TYPE,
            self::CLIENT_TYPE => self::CLIENT_TYPE,
            self::ADMIN => self::ADMIN,
        ];
    }

    public static function filterableUserType()
    {
        $userTypes = [
            self::CLIENT_TYPE => trans("users." . self::CLIENT_TYPE),
            self::ADMIN => trans("users." . self::ADMIN),
        ];
        asort($userTypes);
        return $userTypes;
    }

    public static function availableUserTypeTransleted()
    {
        return [

            self::CLIENT_TYPE => trans("users." . self::CLIENT_TYPE),
            self::ADMIN => trans("users." . self::ADMIN),
        ];
    }


    public static function getList()
    {
        return [
            self::SUPER_ADMIN_TYPE => trans("users." . self::SUPER_ADMIN_TYPE),
            self::ADMIN => trans("users." . self::ADMIN),
            self::CLIENT_TYPE => trans("users." . self::CLIENT_TYPE),
        ];
    }

    public static function getLabel($key)
    {
        return array_key_exists($key, self::getList()) ? self::getList()[$key] : " ";
    }
}
