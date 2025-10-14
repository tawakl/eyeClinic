<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Enums;

class S3Enums
{
    public const LARGE_PATH = "uploads/large/",
        SMALL_PATH = "uploads/small/",
        GARBAGE_MEDIA_PATH = 'garbage_media/',
        UPLOADED_MEDIA_PATH = 'uploaded_media/',
        PDFS_MEDIA_PATH = 'uploads/pdfs_media/',
        PDFS_ZIP_MEDIA_PATH = 'uploads/pdfs_media/invoices/',
        UPLOADS_PATH = 'uploads/',
        RESIZE = "resize",
        LARGE = "large",
        SMALL = "small",
        CROP = "crop";
}
