<?php

declare(strict_types = 1);

namespace App\Modules\GarbageMedia\Requests\Api;

use App\Modules\GarbageMedia\Enums\GarbageMediaEnum;
use Illuminate\Foundation\Http\FormRequest;

class PostMedia extends FormRequest
{
    public function rules()
    {
        return [
            'media' => 'required|array',
            'media.*' => 'required|mimes:' . implode(
                ',',
                GarbageMediaEnum::getAvailableMediaExtensions()
            ) . '|max:' . GarbageMediaEnum::UPLOAD_IMAGE_MAX_SIZE,
        ];
    }
}
