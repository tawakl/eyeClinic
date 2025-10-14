<?php

declare(strict_types = 1);

namespace App\Modules\LookUp\Transformers;

use App\Modules\Courses\Models\Course;
use App\Modules\LookUp\Enums\LookupEnums;
use League\Fractal\TransformerAbstract;

class CoursesLookUpTransformer extends TransformerAbstract
{

    protected array $availableIncludes = [
    ];

    private $param;



    /**
     * @return array
     */
    public function transform(Course $course)
    {
        return [
            'id' => $course->id,
            'label' => $course->name,
            'start_date' => $course->start_date,
            'end_date' => $course->end_date,
            'key' => LookupEnums::COURSES_ID,
            'value' => $course->id,
            'filter_type' => LookupEnums::FILTER
        ];
    }
}
