<?php

declare(strict_types = 1);

namespace App\Modules\Users\Models;

use App\Modules\BaseApp\BaseModel;

class PasswordReset extends BaseModel
{

    protected $table = 'password_resets';

    public $timestamps = false;

    protected $fillable = ['email', 'token', 'created_at', 'mobile'];
}
