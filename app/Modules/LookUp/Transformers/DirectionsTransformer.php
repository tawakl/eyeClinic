<?php

declare(strict_types = 1);

namespace App\Modules\LookUp\Transformers;

use App\Modules\LookUp\Enums\LookupEnums;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class DirectionsTransformer extends TransformerAbstract
{
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];


    /**
     * @return array
     */
    public function transform($row)
    {
        return [
            'id' => Str::uuid(),
            'label' => $row['label'],
            'value' => $row['value'],
            'key' => $row['key'],
            'filter_type' => LookupEnums::SORT
        ];
    }
}
