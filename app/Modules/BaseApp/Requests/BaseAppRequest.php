<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseAppRequest extends FormRequest
{
    public function rules()
    {
        return [];
    }
}
