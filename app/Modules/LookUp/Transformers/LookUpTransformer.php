<?php

declare(strict_types = 1);

namespace App\Modules\LookUp\Transformers;

use App\Modules\BaseApp\Enums\ResourceTypesEnums;
use App\Modules\LookUp\Enums\LookupEnums;
use App\Modules\Users\Repository\UserRepository;
use App\Modules\Users\UserEnums;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class LookUpTransformer extends TransformerAbstract
{
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [
        'instructors',
        'price',
        'studentCourses',
        'instructorCourses',
        'rate'
    ];

    private $param;

    public function __construct(array $param)
    {
        $this->param = $param;
    }

    /**
     * @return array
     */
    public function transform()
    {
        return [
            'id' => Str::uuid()
        ];
    }

    public function includeInstructors()
    {
        $filters[LookupEnums::USER_TYPE] = UserEnums::INSTRUCTOR_TYPE;
        $filters[LookupEnums::ACTIVE] = true;
        $instructors = (new UserRepository())->all($filters);
        return $this->collection($instructors, new UserLookUpTransformer(), ResourceTypesEnums::INSTRUCTOR);
    }

    public function includeStudentCourses()
    {
        if ($user = $this->param['user']) {
            $courses = $user->studentCourses()->where('is_active', true)->get();
            return $this->collection($courses, new CoursesLookUpTransformer(), ResourceTypesEnums::COURSE);
        }
    }

    public function includeInstructorCourses()
    {
        if ($user = $this->param['user']) {
            $courses = $user->instructorCourses()->where('is_active', true)->get();
            return $this->collection($courses, new CoursesLookUpTransformer(), ResourceTypesEnums::COURSE);
        }
    }

    public function includePrice()
    {
        return $this->collection(
            LookupEnums::getSortDirections(LookupEnums::PRICE),
            new DirectionsTransformer(),
            ResourceTypesEnums::PRICE_SORT_KEY
        );
    }

    public function includeRate()
    {
        return $this->collection(
            LookupEnums::getSortDirections(LookupEnums::RATE),
            new DirectionsTransformer(),
            ResourceTypesEnums::RATE_SORT_KEY
        );
    }
}
