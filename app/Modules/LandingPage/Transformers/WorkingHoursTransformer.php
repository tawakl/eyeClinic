<?php

namespace App\Modules\LandingPage\Transformers;

use League\Fractal\TransformerAbstract;

class WorkingHoursTransformer extends TransformerAbstract
{
    public function transform($item)
    {
        if (empty($item)) {
            return [
                'day' => null,
                'periods' => [],
            ];
        }

        if (isset($item['day'])) {
            return [
                'day' => $item['day'],
                'periods' => $item['periods'] ?? [],
            ];
        }

        if (isset($item['from']) && isset($item['to'])) {
            return [
                'from' => $item['from'],
                'to' => $item['to'],
            ];
        }

        return $item;
    }
}
