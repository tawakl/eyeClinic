<?php

declare(strict_types = 1);

namespace App\Modules\Users\Repository;

use App\Modules\BaseApp\Scopes\StagingAdminScope;
use App\Modules\LookUp\Enums\LookupEnums;
use App\Modules\Users\Models\PasswordReset;
use App\Modules\Users\User;
use App\Modules\Users\UserEnums;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    private User $user;

    public function __construct($user = null)
    {
        if ($user instanceof User) {
            $this->user = $user;
        } else {
            $this->user = new User();
        }
    }

    public function findOrFail($id): User
    {
        return $this->user->query()->findOrFail($id);
    }

    public function findByCol(string $col,mixed $key)
    {
        return $this->user->query()
            ->where($col, $key)
            ->first();
    }

    public function getPluckUserByType(string $type): array
    {
        return $this->user->query()->where('type', $type)->where('is_active',true)->stagingAdmin()->get()->pluck('name', 'id')->toArray();
    }

    public function all(
        array $filters = [], $limit = null
    ) {
        $query = $this->user
            ->query()
            ->when(isset($filters['first_name']), function ($q) use ($filters) {
                $q->where('first_name', 'like', '%' . $filters['first_name'] . '%');
            })
            ->when(isset($filters['last_name']), function ($q) use ($filters) {
                $q->where('last_name', 'like', '%' . $filters['last_name'] . '%');
            })
            ->when(isset($filters['email']), function ($q) use ($filters) {
                $q->where('email', 'like', '%' . $filters['email'] . '%');
            })
            ->when(isset($filters['mobile']), function ($q) use ($filters) {
                $q->where('mobile', 'like', '%' . $filters['mobile'] . '%');
            })
            ->when(isset($filters[LookupEnums::ACTIVE]), function ($q) use ($filters) {
                    $q->where('is_active', $filters[LookupEnums::ACTIVE]);
            })
            ->when(isset($filters[LookupEnums::USER_TYPE]), function ($qu) use ($filters) {
                $qu->where('type', '=', $filters[LookupEnums::USER_TYPE]);
            })
            ->when(isset($filters[LookupEnums::LIMIT]), function ($qu) use ($filters) {
                $qu->limit($filters[LookupEnums::LIMIT]);
            })
            ->when(isset($filters[LookupEnums::RANDOM]) && $filters[LookupEnums::RANDOM], function ($qu) {
                $qu->inRandomOrder();
            })
            ->where('type', '!=' , UserEnums::SUPER_ADMIN_TYPE)
            ->when(isset($filters[LookupEnums::SEARCH_KEY]), function ($qu) use ($filters) {
                $qu->where(function ($q) use ($filters) {
                    $q->where('first_name', 'like', '%' . $filters[LookupEnums::SEARCH_KEY] . '%')
                        ->orWhere('last_name', 'like', '%' . $filters[LookupEnums::SEARCH_KEY] . '%')
                        ->orWhereRaw(
                            "CONCAT(first_name, ' ', last_name) LIKE ?",
                            ['%' . $filters[LookupEnums::SEARCH_KEY] . '%']
                        );
                });
            });
        if (isset($limit)) {
            $query = $query->limit($limit);
        }
        if (isset($filters[LookupEnums::PAGINATE]) && $filters[LookupEnums::PAGINATE]) {
            return $query->jsonPaginate($filters[LookupEnums::PER_Page]);
        }
        return $query->get();
    }

    public function findUserByOtp(string $code)
    {
        return $this->user->query()->where('otp', $code)->first();
    }

    public function create(array $data): User
    {
        return $this->user->query()->create($data);
    }

    public function findByMobile($mobile)
    {
        return $this->user->query()->where('mobile', $mobile)->first();
    }

    public function update(array $data,int $id): bool
    {
        $user = $this->findOrFail($id);
        return $user->update($data);
    }

    public function updateUser(User $user, array $data): bool
    {
        return $user->update($data);
    }
    public function createResetPassword(array $data): PasswordReset
    {
        return PasswordReset::create($data);
    }

    public function listUsersByType($userType, $limit = null)
    {
        $query = $this->user
            ->query()
            ->where('type', $userType)
            ->withoutGlobalScopes()
            ->active();
        if (isset($limit)) {
            $query = $query->limit($limit);
        }
        return $query->get();
    }
}
