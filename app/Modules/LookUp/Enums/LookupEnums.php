<?php

declare(strict_types = 1);

namespace App\Modules\LookUp\Enums;

class LookupEnums
{
    public const
        ASC = 'asc',
        DESC = 'desc',
        SORT = 'sort',
        FILTER = 'filter',
        FROM = 'from',
        PROMO_CODE_TYPE = 'promo_code_type',
        TO = 'to',
        SEARCH_KEY = 'search_key',

        CREATION_DATE = 'creation_date',
        PRICE = 'price',
        RATE = 'rate',
        VISITS = 'visits',
        RANDOM = 'random',
        PAGINATE = 'paginate',
        PER_Page = 'per_page',
        ACTIVE = 'active',
        SUBSCRIBED = 'subscribed',
        USER_TYPE = 'type',
        LIMIT = 'limit',
        STUDENT_ID = 'student_id',
        IS_PUBLISHED = 'is_published',
        DATE = 'date',
        IS_ACTIVE = 'is_active',
        EMAIL = 'email',
        IS_SOLVED = 'is_solved',
        PROMO_CODE_ID = 'promo_code_id',
        NAME = 'name',
        ACTION = 'action',
        PUBLISH_DATE = 'publish_date',
        DESCRIPTION = 'description',
        TESTING = 'testing';

    public static function getSortDirections($key)
    {
        return
            [
                [
                    'label' => trans('app.' . self::ASC),
                    'value' => self::ASC,
                    'key' => $key
                ],
                [
                    'label' => trans('app.' . self::DESC),
                    'value' => self::DESC,
                    'key' => $key
                ]
            ];
    }
}
