<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Enums;

class DynamicLinksEnum
{
    public const
        DYNAMIC_URL_PATTERN = '{portal_url}/dynamic-link?{query_param}&apn={android_apn}',
        INSTRUCTOR_JOIN_ROOM = '{portal_url}/#/home?osession={session_id}&otoken={token}&otype={type}',
        JOIN_ROOM = 'join_room',
        RESET_PASSWORD = 'reset_password',
        COURSE_DETAILS_PAGE = 'course_details',
        START_EXAM = 'start_exam';
}
