<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Api\Transformers;

use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class ActionTransformer extends TransformerAbstract
{
    protected array $defaultIncludes = [
    ];

    protected array $availableIncludes = [
    ];


    public function transform($action)
    {
        return [
            'id' => Str::uuid(),
            'endpoint_url' => (string) $action['endpoint_url'],
            'method' => $action['method'] ?? null,
            'label' => (string) $action['label'],
            'bg_color' => (string) ($action['bg_color'] ?? '#228B22'),
            'key' => (string) ($action['key'] ?? null)
        ];
    }
}
