<?php

declare(strict_types = 1);

namespace App\Modules\Testimonials\Repository;

use App\Modules\Ratings\Rating;
use App\Modules\Testimonials\Testimonial;

class TestimonialRepository
{
    private Testimonial $testimonial;

    public function __construct($testimonial = null)
    {
        if ($testimonial instanceof Testimonial) {
            $this->testimonial = $testimonial;
        } else {
            $this->testimonial = new Testimonial();
        }
    }

    public function all()
    {
        return $this->testimonial->query()->stagingAdmin()->paginate();
    }

    public function activeTestimonials()
    {
        return $this->testimonial->query()->where('status', true)->stagingAdmin()->get();
    }

    public function create(array $data)
    {
        return $this->testimonial->query()->create($data);
    }


    public function countActiveTestimonials(): int
    {
        return $this->testimonial->query()->where('status', true)->count();
    }

    public function allRating()
    {
        return Rating::query()->stagingAdmin()->paginate();
    }

    public function isRatingAlreadyTestimonial(Rating $rating): bool
    {
        return $this->testimonial->query()
            ->where('review', $rating->comment)
            ->where('name', $rating->user->name)
            ->stagingAdmin()
            ->exists();
    }
}
