<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Scopes;

use App\Modules\Users\UserEnums;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class ActiveScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.Exa
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check()) {
            if (in_array(auth()->user()->type, [UserEnums::STUDENT_TYPE])) {
                $builder->where('is_active', '=', 1);
            }
        }
    }
}
