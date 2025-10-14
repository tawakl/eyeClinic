<?php

declare(strict_types = 1);

namespace App\Modules\GarbageMedia\Enums;

class GarbageMediaEnum
{
    public const
        UPLOAD_IMAGE_MAX_SIZE = 20480,
        JPEG = 'jpeg',
        PNG = 'png',
        JPG = 'jpg',
        GIF = 'gif',
        SVG = 'svg',
        PDF = 'pdf',
        XLS = 'xls',
        CSV = 'csv',
        TXT = 'txt',
        XLSX = 'xlsx',
        MP4 = 'mp4',
        WEBM = 'webm',
        WMV = 'wmv',
        AVI = 'avi',
        FLV = 'flv',
        SWF = 'swf',
        MPGA = 'mpga',
        AUDIO = 'audio',
        MPEG = 'mpeg',
        DOC = 'doc',
        DOCX = 'docx',
        MP3 = 'mp3',
        ONE = 'one';


    public static function getAvailableMediaExtensions()
    {
        return [
            self::JPEG,
            self::PNG,
            self::JPG,
            self::GIF,
            self::SVG,
            self::PDF,
            self::XLS,
            self::CSV,
            self::TXT,
            self::XLSX,
            self::MP4,
            self::WEBM,
            self::WMV,
            self::AVI,
            self::FLV,
            self::SWF,
            self::MPGA,
            self::AUDIO,
            self::MPEG,
            self::DOC,
            self::DOCX,
            self::MP3,
            self::ONE
        ];
    }
}
