<?php

declare(strict_types = 1);

namespace App\Modules\GarbageMedia\Requests\Api;

use App\Modules\BaseApp\Api\Requests\BaseApiParserRequest;
use App\Modules\GarbageMedia\Enums\GarbageMediaEnum;

class UploadMedia extends BaseApiParserRequest
{
    public function rules()
    {
        return [
            'attributes.media' => 'required|array',
            'attributes.media.*' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf,xls,csv,txt,xlsx,mp4,webm,wmv,avi,flv,swf,mpga,audio,mpeg,doc,docx,mp3,one|max:'.GarbageMediaEnum::UPLOAD_IMAGE_MAX_SIZE,
        ];
    }
}
