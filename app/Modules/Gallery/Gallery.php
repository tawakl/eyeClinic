<?php

declare(strict_types = 1);

namespace App\Modules\Gallery;

use App\Modules\BaseApp\BaseModel;


class Gallery extends BaseModel
{

    protected $fillable = ['image', 'caption'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): string
    {
        if ($this->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }

        return asset('assets/img/default-user.png');
    }

}
