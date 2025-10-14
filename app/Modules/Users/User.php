<?php

declare(strict_types = 1);

namespace App\Modules\Users;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use SoftDeletes;
//    use HasAttach;
    use Notifiable;

//    protected static $attachFields = [
//        'profile_picture' => [
//            'sizes' => [S3Enums::SMALL => 'crop,400x300', S3Enums::LARGE => 'resize,800x600'],
//            'modulePath' => 'profiles',
//            'path' => S3Enums::UPLOADS_PATH
//        ],
//    ];
    protected $table = "users";
    protected $fillable = [
        'first_name',
        'last_name',
        'type',
        'email',
        'mobile',
        'password',
        'is_active',
        'profile_picture',
    ];

    public function setPasswordAttribute($value)
    {
        if (!is_null($value)) {
            $this->attributes['password'] = bcrypt(trim($value));
        }
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

}
