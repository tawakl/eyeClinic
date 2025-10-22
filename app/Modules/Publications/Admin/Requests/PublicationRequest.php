<?php

namespace App\Modules\Publications\Admin\Requests;

use App\Modules\BaseApp\Requests\BaseAppRequest;

class PublicationRequest extends BaseAppRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'published_year' => 'nullable',
        ];
    }
}
