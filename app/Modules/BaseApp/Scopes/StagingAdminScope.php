<?php

declare(strict_types = 1);

namespace App\Modules\BaseApp\Scopes;

use App\Modules\Users\Repository\UserRepository;
use App\Modules\Users\UserEnums;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Log;

class StagingAdminScope implements Scope
{
    public function __construct(private $colum = 'created_by', private $relation = null)
    {
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (!empty($this->relation)) {
            $builder->whereHas($this->relation, fn($q) => $this->filterBycolum($q));
        } else {
            $this->filterBycolum($builder);
        }
    }

    private function filterByColum($builder): void
    {
        //admin
        if (auth()->guard('web')->user() &&
            auth()->guard('web')->user()->type == UserEnums::STAGING_SUPER_ADMIN_TYPE) {
            //case 1 : if user is logged in as staging admin
            $builder->where($this->colum, auth()->guard('web')->id());
        } else {
            $stagingSuperAdminsIds = (new UserRepository())
                ->listUsersByType(UserEnums::STAGING_SUPER_ADMIN_TYPE)
                ->pluck('id')
                ->toArray();
            //case 2 : if user is logged as a super admin
            if (auth()->guard('web')->user()) {
                $builder->whereNotIn($this->colum, $stagingSuperAdminsIds)
                    ->orWhereNull($this->colum);
                //case 3 : if user is logged as an api user (real user dont return staging admin data)
            } elseif ($authApiUser = auth()->guard('api')->user()) {
                if (!in_array($authApiUser->created_by, $stagingSuperAdminsIds)) {
                    $builder->whereNotIn($this->colum, $stagingSuperAdminsIds);
                } else {
                    $builder->whereIn($this->colum, $stagingSuperAdminsIds);
                }
            } elseif (request()->hasHeader('testing')) {
                $builder->whereIn($this->colum, $stagingSuperAdminsIds);
            } elseif (!request()->hasHeader('testing')) {
                $builder->whereNotIn($this->colum, $stagingSuperAdminsIds);
            }
        }
    }
}
