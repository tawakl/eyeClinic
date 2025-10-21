<?php

declare(strict_types=1);

namespace App\Modules\LandingPage\Transformers;

use App\Modules\Team\Team;
use League\Fractal\TransformerAbstract;

class TeamTransformer extends TransformerAbstract
{
    public function transform(Team $team): array
    {
        return [
            'id'          => $team->id,
            'name'        => $team->name,
            'title'       => $team->title,
            'description' => $team->description,
            'image'       => $team->image_url,
        ];
    }
}
