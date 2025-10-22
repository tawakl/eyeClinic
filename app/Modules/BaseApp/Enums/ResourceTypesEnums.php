<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Enums;

abstract class ResourceTypesEnums
{
    public const

        USER = 'user',
        RESET_PASSWORD = 'reset_password',
        ACTION = 'action',
        GALLERY = 'gallery',
        PUBLICATION = 'publication',
        TEAM_MEMBER = 'team_member',
        WORKING_HOURS = 'working_hours',
        CONFIG = 'config';
}
