<?php

declare(strict_types = 1);

namespace App\Modules\Users\UseCases;

use App\Modules\Users\Repository\UserRepository;
use App\Modules\Users\User;
use App\Modules\Users\UserEnums;

class ActivateUserUseCase
{

    public function activateWithOtp($code): ?User
    {
        $user = (new UserRepository())->findUserByOtp($code);
        if ($user) {
            $user->otp = null;
            $user->confirmed = true;
            $user->save();
        }

        return $user;
    }

    public function reActivateProfile($data)
    {
        $user = (new UserRepository())->findByMobile($data->mobile);
        $errors = $this->validateReactivateProfile($user);
        if (count($errors)) {
            return $errors;
        }
        (new UserRepository())->updateUser($user, ['deleted_by_user_action' => 0]);
        return [
            'code' => 200,
            'message' => trans('api.Profile Reactivated Successfully'),
            'title' => 'Profile Reactivated Successfully'
        ];
    }

    private function validateReactivateProfile($user): array
    {
        if (!$user) {
            $errors ['code'] = 422;
            $errors['title'] = 'There is no account with this mobile';
            $errors['message'] = trans('auth.There is no account with this mobile');

            return $errors;
        }
        if (!$user->deleted_by_user_action) {
            $errors ['code'] = 422;
            $errors['title'] = 'This account is not deactivated';
            $errors['message'] = trans('auth.This account is not deactivated');
            return $errors;
        }
        return [];
    }
}
