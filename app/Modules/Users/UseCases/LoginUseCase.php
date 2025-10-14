<?php

declare(strict_types = 1);

namespace App\Modules\Users\UseCases;

use App\Modules\Users\Repository\UserRepository;
use App\Modules\Users\UserEnums;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoginUseCase
{
    public function login(array $request, string $attribute = UserEnums::USER_LOGIN_EMAIL_TYPE): array
    {
        $userRepository = new UserRepository();
        $user = $userRepository->findByCol(col: $attribute, key: $request['loginKey']);
        $validateLogin = $this->validateLogin($request, $user, $attribute);

        if ($validateLogin) {
            return $validateLogin;
        }

        $login = [$attribute => $request['loginKey'], 'password' => $request['password'],];
        if (Auth::attempt($login, $request['remember_me'])) {
            $user->update(
                [
                    'language' => app()->getLocale()
                ]
            );
            $loginCase['user'] = $user;
            $loginCase['status'] = 200;
            $loginCase['title'] = 'Welcome to your dashboard';
            $loginCase['detail'] = __('auth.Welcome to your dashboard');
        } else {
            $loginCase['user'] = null;
            $loginCase['title'] = 'Oopps Something is broken';
            $loginCase['detail'] = __('app.Oopps Something is broken');
        }
        return $loginCase;
    }

    private function validateLogin(array $request, $user, $attribute): array
    {
        $loginCase = [];
        if (!$user) {
            $loginCase['user'] = null;
            $loginCase['status'] = 422;
            if ($attribute == UserEnums::USER_LOGIN_EMAIL_TYPE) {
                $loginCase['title'] = 'There is no account with this email';
                $loginCase['detail'] = __('auth.There is no account with this email');
            } else {
                $loginCase['title'] = 'There is no account with this mobile';
                $loginCase['detail'] = __('auth.There is no account with this mobile');
            }


            return $loginCase;
        }
        if (!isset($request['password']) || $request['password'] === null) {
            $loginCase['user'] = null;
            $loginCase['status'] = 422;
            $loginCase['title'] = 'Password field is required';
            $loginCase['detail'] = __('auth.Password field is required');

            return $loginCase;
        }
        if (!Hash::check(trim($request['password']), $user->password)) {
            $loginCase['user'] = null;
            $loginCase['status'] = 422;
            $loginCase['title'] = 'Trying to login with invalid password';
            $loginCase['detail'] = __('auth.Trying to login with invalid password');

            return $loginCase;
        }
        if (!$user->is_active) {
            $loginCase['user'] = null;
            $loginCase['status'] = 422;
            $loginCase['title'] = 'This account is banned';
            $loginCase['detail'] = trans('auth.This account is banned');

            return $loginCase;
        }
        if ($user->deleted_by_user_action) {
            $loginCase['user'] = null;
            $loginCase['status'] = 422;
            $loginCase['title'] = 'This account is deactivated message';
            $loginCase['detail'] = trans('auth.This account is deactivated message');

            return $loginCase;
        }
        return $loginCase;
    }
}
