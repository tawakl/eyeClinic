<?php

declare(strict_types = 1);

namespace App\Modules\Users\UseCases;

use App\Modules\Users\Jobs\SendActivationCode;
use App\Modules\Users\Repository\UserRepository;
use App\Modules\Users\User;
use App\Modules\Users\UserEnums;

class RegisterUseCase
{
    public function register(array $request): User
    {
        $request['language'] = "ar";
        $user = (new UserRepository())->create($request);
        return $user;
    }
}
