<?php

declare(strict_types = 1);

namespace App\Modules\LandingPage\Transformers;
use App\Modules\Config\Config;
use League\Fractal\TransformerAbstract;

class ConfigsTransformer extends TransformerAbstract
{
    protected array $defaultIncludes = [

    ];
    protected array $availableIncludes = [

    ];

    public function transform(Config $config): array
    {
        return [
            'id' => $config->id,
            'field' => $config->key,
//            'value' => $config->value ?? null,
            'value' => json_decode($config->value, true) ?? $config->value,
        ];
    }
}
