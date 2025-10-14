<?php

declare(strict_types = 1);

namespace App\Modules\Users\Auth\Controllers;

use App\Modules\BaseApp\Controllers\BaseController;
use App\Modules\Users\Auth\Requests\ResetPasswordRequest;
use App\Modules\Users\Auth\Requests\UserLoginRequest;
use App\Modules\Users\UseCases\ForgetPasswordUseCase;
use App\Modules\Users\UseCases\LoginUseCase;

class AuthController extends BaseController
{
    private string $module;

    public function __construct()
    {
        $this->module = 'auth';
    }


    public function getLogin()
    {
        $data['page_title'] = __('auth.Login');
        $data['module'] = $this->module;
        return view($this->module . '.login', $data);
    }

    public function postLogin(UserLoginRequest $request)
    {
        $requestData = [];
        $requestData['loginKey'] = $request->email;
        $requestData['password'] = $request->password;
        $requestData['remember_me'] = $request->get('remember_me');
        $useCase = (new LoginUseCase())->login($requestData);
        if (!is_null($useCase['user'])) {
            return redirect()->intended(route('admin.dashboard'));
        } else {
            flash()->error($useCase['detail']);
            return redirect()->back()->withInput();
        }
    }

    public function getForgotPassword()
    {
        $data['page_title'] = __('auth.reset password');
        $data['module'] = $this->module;
        return view($this->module . '.resetPassword', $data);
    }

    public function postForgotPassword(ResetPasswordRequest $request)
    {
        $useCase = (new ForgetPasswordUseCase())->sendPasswordResetMail($request->email);
        if ($useCase['code'] == 200) {
            flash(trans($useCase['message']))->success();
            return back()->withInput();
        } else {
            flash(trans($useCase['message']))->info();
            return back()->withInput();
        }
    }
}
