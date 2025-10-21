<?php

namespace App\Modules\Config\Requests;

use App\Modules\BaseApp\Requests\BaseAppRequest;

class ConfigRequest extends BaseAppRequest
{
    public function rules(): array
    {
        return [
            'clinic_name' => 'nullable|string|max:255',
            'clinic_address' => 'nullable|string|max:255',
            'clinic_phone' => 'nullable|string|max:30',
            'clinic_email' => 'nullable|email',
            'clinic_latitude' => 'nullable|numeric',
            'clinic_longitude' => 'nullable|numeric',
            'working_hours' => 'array',
            'working_hours.*.day' => 'nullable|string|max:20',
            'working_hours.*.from' => 'nullable|date_format:H:i',
            'working_hours.*.to' => 'nullable|date_format:H:i',
            'closing_periods' => 'array',
            'closing_periods.*.from' => 'nullable|date',
            'closing_periods.*.to' => 'nullable|date',
            'closing_periods.*.reason' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'clinic_email.email' => 'The email format is invalid.',
            'clinic_latitude.numeric' => 'Latitude must be numeric.',
            'clinic_longitude.numeric' => 'Longitude must be numeric.',
        ];
    }
}
