<?php

declare(strict_types = 1);

namespace App\Modules\Users\Admin\Controllers;

use App\Modules\BaseApp\Controllers\AjaxController;
use App\Modules\Users\Repository\UserRepository;
use App\Modules\Users\UserEnums;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

class AjaxUsersController extends AjaxController
{
    public function getInstructors()
    {
        $instructors=[];

            $instructors = (new UserRepository())->getPluckUserByType(UserEnums::INSTRUCTOR_TYPE);

        return response()->json(
            [
                'status' => '200',
                'instructors' => $instructors
            ]
        );
    }

    public function searchStudents()
    {
        $users = $this->repository->searchStudentsByEmail(request('q'));

        return response()->json(
            [
                'status' => '200',
                'users' => $users,
            ]
        );
    }
}
