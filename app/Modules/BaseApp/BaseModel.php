<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
