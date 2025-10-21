<?php

declare(strict_types = 1);

namespace App\Modules\LandingPage\Transformers;
use App\Modules\Gallery\Gallery;
use League\Fractal\TransformerAbstract;

class GalleryTransformer extends TransformerAbstract
{
    protected array $defaultIncludes = [

    ];
    protected array $availableIncludes = [

    ];

    public function transform(Gallery $gallery): array
    {
        return [
            'id' => $gallery->id,
            'image' => $gallery->image_url ?? null,
            'caption' => $gallery->caption ?? null,
        ];
    }
}
