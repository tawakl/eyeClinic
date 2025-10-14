<?php

declare(strict_types = 1);

namespace App\Modules\Users\Transformers;

use App\Modules\BaseApp\Api\Enums\APIActionsEnums;
use App\Modules\BaseApp\Api\Transformers\ActionTransformer;
use App\Modules\BaseApp\Enums\ResourceTypesEnums;
use App\Modules\BaseApp\Enums\S3Enums;
use App\Modules\Users\User;
use App\Modules\Users\UserEnums;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected array $defaultIncludes = [
    ];

    protected array $availableIncludes = [
        'actions'
    ];

    public function __construct()
    {
    }

    public function transform(User $user): array
    {
        $returnData = [
            'id' => (int)$user->id,
            'type' => $user->type,
            'name' => $user->name,
            'first_name' => (string)$user->first_name,
            'last_name' => (string)$user->last_name,
            'language' => (string)$user->language,
            'mobile' => (string)$user->mobile,
            'profile_picture' => (string)image(img: $user->profile_picture, type: S3Enums::SMALL),
            'email' => (string)$user->email,
            'user_id' => (int)$user->id,
        ];
        return $returnData;
    }

    public function includeActions(User $user)
    {
        $actions = [];
        $actions[] = [
            'endpoint_url' => buildScopeRoute('api.profile.updateProfile'),
            'label' => trans('update_profile'),
            'method' => 'POST',
            'key' => APIActionsEnums::UPDATE_PROFILE
        ];

        $actions[] = [
            'endpoint_url' => buildScopeRoute('api.profile.updatePassword'),
            'label' => trans('update_password'),
            'method' => 'POST',
            'key' => APIActionsEnums::UPDATE_PASSWORD
        ];
        if (count($actions) > 0) {
            return $this->collection($actions, new ActionTransformer(), ResourceTypesEnums::ACTION);
        }
        return [];
    }
}
