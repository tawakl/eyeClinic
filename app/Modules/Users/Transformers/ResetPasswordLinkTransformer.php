<?php

declare(strict_types = 1);

namespace App\Modules\Users\Transformers;

use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class ResetPasswordLinkTransformer extends TransformerAbstract
{

    public function transform($data): array
    {
        return [
            'id' => Str::uuid(),
            'url' => $data['url'],
            'token' => $data['token'],
        ];
    }
}
