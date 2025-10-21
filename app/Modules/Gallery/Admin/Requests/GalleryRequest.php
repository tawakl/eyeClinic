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
        $rules = [
            'caption' => 'nullable|string|max:255',
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|mimes:jpg,jpeg,png,webp|max:2048';
        } else {
            $rules['image'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        }

        return $rules;
    }


}
