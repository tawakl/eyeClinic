<?php

namespace App\Modules\WorkingHours\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClinicWorkingDayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

        ];
    }

}
