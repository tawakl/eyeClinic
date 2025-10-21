<?php

namespace App\Modules\WorkingHours;
use Illuminate\Database\Eloquent\Model;

class ClinicWorkingDay extends Model
{
    protected $fillable = [
        'day',
        'from_time',
        'to_time',
        'break_from',
        'break_to',
        'slot_duration',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
