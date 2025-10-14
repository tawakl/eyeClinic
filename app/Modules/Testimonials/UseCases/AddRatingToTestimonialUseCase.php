<?php

declare(strict_types = 1);

namespace App\Modules\Testimonials\UseCases;

use App\Modules\Ratings\Rating;
use App\Modules\Testimonials\Enums\TestimonialsEnums;
use App\Modules\Testimonials\Repository\TestimonialRepository;

class AddRatingToTestimonialUseCase
{
    protected $repository;

    public function __construct(TestimonialRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(Rating $rating)
    {
        $activeTestimonialsCount = $this->repository->countActiveTestimonials();

        if ($activeTestimonialsCount >= 7) {
            return [
                'status' => 'error',
                'message' => trans('testimonials.Cannot add more than 7 active testimonials.'),
                'route' => route('admin.testimonials.getRating')
            ];
        }

        $testimonialData = [
            'rating_id' => $rating->id,
            'name' => $rating->user->name,
            'job' => TestimonialsEnums::TRAINEE,
            'review' => $rating->comment,
            'status' => true,
            'image' => $rating->user->profile_picture,
        ];

        $this->repository->create($testimonialData);

        return [
            'status' => 'success',
            'message' => trans('testimonials.Testimonial added successfully.'),
            'route' => route('admin.testimonials.get.index')
        ];
    }
}
