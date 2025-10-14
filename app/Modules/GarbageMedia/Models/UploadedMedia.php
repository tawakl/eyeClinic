<?php

declare(strict_types = 1);

namespace App\Modules\GarbageMedia\Models;

use App\Modules\BaseApp\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class UploadedMedia extends BaseModel
{
    use SoftDeletes ;

    protected $fillable =[
        'source_filename',
        'filename',
        'size',
        'mime_type',
        'url',
        'extension',
        'status'
    ];
}
