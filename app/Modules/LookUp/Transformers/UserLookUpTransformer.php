<?php

declare(strict_types = 1);

namespace App\Modules\LookUp\Transformers;

use App\Modules\LookUp\Enums\LookupEnums;
use App\Modules\Users\User;
use League\Fractal\TransformerAbstract;

class UserLookUpTransformer extends TransformerAbstract
{

    protected array $availableIncludes = [
    ];

    private $param;



    /**
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'label' => $user->name,
            'key' => LookupEnums::INSTRUCTOR_ID,
            'value' => $user->id,
            'filter_type' => LookupEnums::FILTER
        ];
    }
}
