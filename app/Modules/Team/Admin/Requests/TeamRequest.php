<?php

namespace App\Modules\Team\Admin\Requests;

use App\Modules\BaseApp\Requests\BaseAppRequest;

class TeamRequest extends BaseAppRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => $this->isMethod('post')
                ? 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
                : 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ];
    }
}
