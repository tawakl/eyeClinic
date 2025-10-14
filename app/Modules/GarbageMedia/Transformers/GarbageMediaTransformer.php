<?php

declare(strict_types = 1);

namespace App\Modules\GarbageMedia\Transformers;

use App\Modules\BaseApp\Enums\S3Enums;
use App\Modules\GarbageMedia\GarbageMedia;
use League\Fractal\TransformerAbstract;

class GarbageMediaTransformer extends TransformerAbstract
{
    protected array $defaultIncludes = [
    ];

    protected array $availableIncludes = [

    ];

    /**
     * @param GarbageMedia $garbageMedia
     * @return array
     */
    public function transform(GarbageMedia $garbageMedia)
    {
        $transfromedData =  [
            'id' => (int) $garbageMedia->id,
//            'size' => (int) $garbageMedia->size,
            'mime_type' => (string) $garbageMedia->mime_type,
            'url' => (string)getFileUrl(S3Enums::GARBAGE_MEDIA_PATH.$garbageMedia->filename),
            'extension' => (string) $garbageMedia->extension,
            'filename' => (string) $garbageMedia->filename,
            'source_filename' => (string) $garbageMedia->source_filename,
        ];
        return $transfromedData;
    }
}
