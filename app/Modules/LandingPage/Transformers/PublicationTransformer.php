<?php

declare(strict_types=1);

namespace App\Modules\LandingPage\Transformers;

use App\Modules\Publications\Publication;
use League\Fractal\TransformerAbstract;

class PublicationTransformer extends TransformerAbstract
{
    public function transform(Publication $publication): array
    {
        return [
            'id'          => $publication->id,
            'title'       => $publication->title,
            'category'    => $publication->category,
            'description' => $publication->description,
            'published_year' => $publication->published_year,

        ];
    }
}
