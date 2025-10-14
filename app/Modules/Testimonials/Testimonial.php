<?php

declare(strict_types = 1);

namespace App\Modules\Testimonials;

use App\Modules\BaseApp\BaseModel;
use App\Modules\BaseApp\Enums\S3Enums;
use App\Modules\BaseApp\Scopes\StagingAdminScope;
use App\Modules\BaseApp\Traits\CreatedBy;
use App\Modules\BaseApp\Traits\HasAttach;
use App\Modules\Ratings\Rating;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends BaseModel
{

    use HasFactory;
    use HasAttach;
    use CreatedBy;

    protected static $attachFields = [
        'image' => [
            'sizes' => [S3Enums::SMALL => 'crop,400x300', S3Enums::LARGE => 'resize,800x600'],
            'modulePath' => 'testimonials',
            'path' => S3Enums::UPLOADS_PATH
        ],
    ];
    protected $table = "testimonials";
    protected $fillable = [
        'name',
        'job',
        'review',
        'image',
        'status',
        'rating_id',
        'created_by',
        'created_at',
    ];
    public function scopeStagingAdmin(Builder $query)
    {
        $stagingAdminGlobalScopeOB = new StagingAdminScope();
        $stagingAdminGlobalScopeOB->apply($query, $this);
    }
    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }
}
