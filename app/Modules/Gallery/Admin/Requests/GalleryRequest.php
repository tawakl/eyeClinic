<?php

declare(strict_types = 1);

namespace App\Modules\Gallery\Admin\Requests;

use App\Modules\BaseApp\Requests\BaseAppRequest;

class GalleryRequest extends BaseAppRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'caption' => 'nullable|string|max:255',
        ];
    }

}
