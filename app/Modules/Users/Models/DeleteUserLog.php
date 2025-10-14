<?php

declare(strict_types = 1);

namespace App\Modules\Users\Models;

use App\Modules\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeleteUserLog extends Model
{
    use HasFactory;

    protected $table = 'delete_user_log';
    protected $fillable = [
        'user_id',
        'deleted_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
