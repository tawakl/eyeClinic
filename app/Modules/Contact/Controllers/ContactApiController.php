<?php

namespace App\Modules\Contact\Controllers;



use App\Modules\BaseApp\Api\BaseApiController;
use App\Modules\Contact\Repository\ContactInterface;
use App\Modules\Contact\Requests\ContactApiRequest;

class ContactApiController extends BaseApiController
{
    private $contactRepo;

    public function __construct(ContactInterface $contactRepo)
    {
        $this->contactRepo = $contactRepo;
    }

    public function postCreate(ContactApiRequest $request) {
        $this->contactRepo->create($request->getData()->toJsonApiArray()['attributes']);

        return response()->json(
            [
                "meta" => [
                    'message' => trans('api.Contact Sent Successfully')
                ]
            ]
        );
    }

}

