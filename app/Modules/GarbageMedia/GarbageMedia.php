<?php

declare(strict_types = 1);

namespace App\Modules\GarbageMedia;

use App\Modules\BaseApp\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class GarbageMedia extends BaseModel
{
    use SoftDeletes, HasFactory;

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
