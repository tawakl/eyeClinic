<?php

declare(strict_types = 1);

namespace App\Modules\Booking;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'name', 'phone','insurance_number', 'email', 'booking_date', 'booking_time', 'status', 'notes'
    ];

    public function getFormattedDateAttribute(): string
    {
        return date('d M Y', strtotime($this->booking_date));
    }

    public function getFormattedTimeAttribute(): string
    {
        return date('h:i A', strtotime($this->booking_time));
    }
}
