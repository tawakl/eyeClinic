<?php

declare(strict_types = 1);

namespace App\Modules\Users\Repository;

use App\Modules\Users\Models\PasswordReset;

class PasswordResetRepository
{
    private PasswordReset $model;

    public function __construct($resetPassword = null)
    {
        if ($resetPassword instanceof PasswordReset) {
            $this->model = $resetPassword;
        } else {
            $this->model = new PasswordReset();
        }
    }

    public function create(array $data)
    {
        return $this->model->query()->create($data);
    }

    public function findByCol($col, $key)
    {
        return $this->model->query()->where($col, $key)->first();
    }

    public function deleteByCol($col, $key)
    {
        return $this->model->query()->where($col, $key)?->delete();
    }
}
