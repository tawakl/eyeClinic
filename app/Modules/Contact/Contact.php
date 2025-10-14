<?php

namespace App\Modules\Contact;

use App\Modules\BaseApp\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends BaseModel {
    use SoftDeletes;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'message',
    ];

}
