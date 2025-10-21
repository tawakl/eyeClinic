<?php

declare(strict_types=1);

namespace App\Modules\Config\Repository;

use App\Modules\Config\Config;

class ConfigRepository
{
    private Config $config;

    public function __construct(Config $config = null)
    {
        $this->config = $config ?? new Config();
    }


    public function get(): array
    {
        return $this->config->pluck('value', 'key')->toArray();
    }


    public function getValue(string $key, $default = null)
    {
        $data = $this->get();
        return $data[$key] ?? $default;
    }
}
