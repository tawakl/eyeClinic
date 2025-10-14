<?php

declare(strict_types = 1);

namespace App\Modules\GarbageMedia\Controllers\Api;

use App\Modules\BaseApp\Api\BaseApiController;
use App\Modules\BaseApp\Enums\ResourceTypesEnums;
use App\Modules\BaseApp\Enums\S3Enums;
use App\Modules\GarbageMedia\GarbageMedia;
use App\Modules\GarbageMedia\Requests\Api\PostMedia;
use App\Modules\GarbageMedia\Transformers\GarbageMediaTransformer;
use Illuminate\Support\Facades\Storage;

class GarbageMediaController extends BaseApiController
{
    public function postMedia(PostMedia $request)
    {
        $files = $request->media;
        $ids = [];
        foreach ($files as $file) {
            $fileName = time() . randString(10) . '.' . $file->getClientOriginalExtension();
            $fileType = $file->getClientMimeType();
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $pathToUpload = S3Enums::GARBAGE_MEDIA_PATH;
            Storage::putFileAs($pathToUpload, $file, $fileName);
            $grabMedia = GarbageMedia::create(
                [
                    'source_filename' => $originalName,
                    'filename' => $fileName,
                    'mime_type' => $fileType,
                    'extension' => $extension,
                    'status' => 1
                ]
            );

            $ids[] = $grabMedia;
        }
        return $this->transformDataMod($ids, new GarbageMediaTransformer(), ResourceTypesEnums::GARBAGE_MEDIA);
    }
}
