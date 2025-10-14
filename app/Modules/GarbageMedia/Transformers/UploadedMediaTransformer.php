<?php

declare(strict_types = 1);

namespace App\Modules\GarbageMedia\Transformers;

use App\Modules\BaseApp\Enums\S3Enums;
use App\Modules\GarbageMedia\Models\UploadedMedia;
use League\Fractal\TransformerAbstract;

class UploadedMediaTransformer extends TransformerAbstract
{
    protected array $defaultIncludes = [
    ];

    protected array $availableIncludes = [

    ];

    /**
     * @param UploadedMedia $garbageMedia
     * @return array
     */
    public function transform(UploadedMedia $garbageMedia)
    {
        $transfromedData =  [
            'id' => (int) $garbageMedia->id,
            'mime_type' => (string) $garbageMedia->mime_type,
            'url' => (string)(getFileUrl(S3Enums::UPLOADED_MEDIA_PATH .$garbageMedia->filename)),
            'extension' => (string) $garbageMedia->extension,
            'filename' => (string) $garbageMedia->filename,
            'source_filename' => (string) $garbageMedia->source_filename,
        ];
        return $transfromedData;
    }
}
