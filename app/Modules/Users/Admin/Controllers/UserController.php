<?php

declare(strict_types = 1);

namespace App\Modules\Users\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BaseApp\Enums\ParentEnum;
use App\Modules\Users\Admin\Requests\CreateUserRequest;
use App\Modules\Users\Admin\Requests\UpdateUserRequest;
use App\Modules\Users\Events\UserModified;
use App\Modules\Users\Repository\UserRepository;
use App\Modules\Users\UseCases\CreateUserUseCase\CreateUserUseCase;

use App\Modules\Users\UseCases\UpdateUserUseCase\UpdateUserUseCase;
use App\Modules\Users\UserEnums;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $title;
    private $module;
    private $filters = [];
    private $parent;

    public function __construct(
    )
    {
        $this->module = 'users';
        $this->title = trans('users.users');
        $this->parent = ParentEnum::ADMIN;
    }

    public function getIndex()
    {
        $validatedData = $this->validate(
            request(),
            [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:255',
            'type' => 'nullable|string|in:' . implode(',', array_keys(UserEnums::filterableUserType())),
            'active' => 'nullable|string',
        ]);

        $data['user_types'] = UserEnums::filterableUserType();
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.List Users');
        $data['breadcrumb'] = '';
        $validatedData['paginate']= true;
        $validatedData['per_page']= 20;
        $data['rows'] = (new UserRepository())->all($validatedData);

        return view($this->parent . '.' . $this->module . '.index', $data);
    }

    public function getCreate()
    {
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.Create') . " " . $this->title;
        $data['breadcrumb'] = [$this->title => route('admin.users.get.index')];
        $data['userType'] = UserEnums::availableUserTypeTransleted();
        return view($this->parent . '.' . $this->module . '.create', $data);
    }


    public function postCreate(CreateUserRequest $request)
    {
        DB::beginTransaction();
        if ((new UserRepository())->create($request->all())) {
            DB::commit();
            flash()->success(trans('app.Created successfully'));
            return redirect()->route('admin.users.get.index');
        }

        flash()->error(trans('app.failed to save'));
        return redirect()->route('admin.users.get.index');
    }

    public function getEdit(int $id)
    {
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.Edit') . " " . $this->title;
        $data['breadcrumb'] = [$this->title => route('admin.users.get.index')];
        $data['row'] = (new UserRepository())->findOrFail($id);
        return view($this->parent . '.' . $this->module . '.edit', $data);
    }

    public function postEdit(UpdateUserRequest $request, int $id)
    {
        $user = (new UserRepository())->findOrFail($id);
        try {
            if ((new UserRepository())->updateUser($user,$request->all())) {
                flash(trans('app.Update successfully'))->success();
                return redirect()->route('admin.users.get.index');
            }

            flash()->error(trans('app.failed to save'));
            return redirect()->route('admin.users.get.index');
        } catch (\Exception $e) {
            flash()->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}
