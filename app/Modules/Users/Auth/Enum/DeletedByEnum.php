<?php

declare(strict_types = 1);

namespace App\Modules\Users\Auth\Enum;

use App\Modules\BaseApp\Enums\DynamicLinksEnum;
use App\Modules\Notifications\Enums\NotificationEnum;
use App\Modules\Users\UserEnums;

class DeletedByEnum
{
    const DELETED_BY_USER = 'deleted_by_user';
    const DELETED_BY_ADMIN = 'deleted_by_admin';
}
