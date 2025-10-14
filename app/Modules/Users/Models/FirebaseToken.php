<?php

declare(strict_types = 1);

namespace App\Modules\Users\Models;

use App\Modules\BaseApp\BaseModel;
use App\Modules\Users\User;

class FirebaseToken extends BaseModel
{
//    use SoftDeletes;


    protected $fillable = ['user_id', 'device_token', 'fingerprint', 'device_type', 'is_school_student'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
