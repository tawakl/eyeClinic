<?php

declare(strict_types = 1);

namespace App\Modules\Users\Admin\Controllers;

use App\Modules\BaseApp\Controllers\BaseController;
use App\Modules\BaseApp\Enums\ParentEnum;
use App\Modules\Users\Admin\Requests\ProfileRequest;
use App\Modules\Users\Events\UserModified;
use App\Modules\Users\Repository\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Modules\Users\UseCases\UpdateProfileUseCase\UpdateProfileUseCase;

class ProfileController extends BaseController
{
    public $module;
    private $parent;

    public function __construct()
    {
        $this->module = 'profile';
        $this->parent = ParentEnum::ADMIN;
    }

    public function getEdit()
    {
        $langs = [];
        foreach (config("translatable.locales") as $lang) {
            $langs[$lang] = trans('app.' . $lang);
        }
        $data['row'] = (new UserRepository())->findOrFail(auth()->user()->id);
        $data['languages'] = $langs;

        $data['page_title'] = trans('profile.Account');
        return view($this->parent . '.' . $this->module . '.edit', $data);
    }

    public function postEdit(ProfileRequest $request)
    {
        $userRepository = new UserRepository();
        $updateProfileUseCase = new UpdateProfileUseCase();
        $useCase = $updateProfileUseCase->updateProfile($request->all(), $userRepository);
        if ($useCase['code'] == 200) {
            flash($useCase['message'])->success();
            return back();
        } else {
            flash(trans($useCase['message']))->error();
            return back()->withInput();
        }
    }

    public function getLogout()
    {
        auth()->logout();
        return redirect()->route('auth.get.login');
    }
}
