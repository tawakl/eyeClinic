<?php

declare(strict_types = 1);

namespace App\Modules\Testimonials\Admin\Requests;

use App\Modules\BaseApp\Requests\BaseAppRequest;
use App\Modules\GarbageMedia\Enums\GarbageMediaEnum;

class CreateTestimonialRequest extends BaseAppRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'job' => 'nullable|string|max:255',
            'review' => 'required|string',
            'image' => 'nullable|image|max:' . GarbageMediaEnum::UPLOAD_IMAGE_MAX_SIZE,
        ];
    }


    public function messages()
    {
        return [
            'image.max' => trans('testimonials.The image size must not exceed 5 MB.'),
        ];
    }
}
