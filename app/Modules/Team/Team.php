<?php

namespace App\Modules\Team;

use App\Modules\BaseApp\BaseModel;

class Team extends BaseModel
{
    protected $table = 'teams';

    protected $fillable = [
        'name',
        'title',
        'description',
        'image',
        'is_active',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('storage/' . $this->image) : asset('assets/img/default-user.png');
    }
}
