<?php

namespace App\Modules\Publications;

use App\Modules\BaseApp\BaseModel;

class Publication extends BaseModel
{
    protected $fillable = [
        'title', 'category', 'description', 'published_year'
    ];

    protected $casts = [
        'published_year' => 'integer',
    ];
}
