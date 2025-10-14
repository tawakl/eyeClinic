<?php

declare(strict_types = 1);

namespace App\Modules\GarbageMedia\Requests\Api;

use App\Modules\BaseApp\Api\Requests\BaseApiParserRequest;
use App\Modules\GarbageMedia\Enums\GarbageMediaEnum;

class PostImages extends BaseApiParserRequest
{
    public function rules()
    {
        return [
            'attributes.images' => 'required|array',
            'attributes.images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:'.GarbageMediaEnum::UPLOAD_IMAGE_MAX_SIZE,
        ];
    }
}
