<?php

namespace App\Modules\WorkingHours;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ClinicClosingPeriod extends Model
{
    protected $fillable = ['from_date', 'to_date', 'reason'];

    public function scopeIsClosedOn(Builder $query, $date)
    {
        return $query->whereDate('from_date', '<=', $date)
            ->whereDate('to_date', '>=', $date);
    }
}
