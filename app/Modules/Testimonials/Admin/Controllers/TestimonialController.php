<?php

declare(strict_types = 1);

namespace App\Modules\Testimonials\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\BaseApp\Enums\ParentEnum;
use App\Modules\Ratings\Rating;
use App\Modules\Testimonials\Admin\Requests\CreateTestimonialRequest;
use App\Modules\Testimonials\Enums\TestimonialsEnums;
use App\Modules\Testimonials\Repository\TestimonialRepository;
use App\Modules\Testimonials\Testimonial;
use App\Modules\Testimonials\UseCases\AddRatingToTestimonialUseCase;

class TestimonialController extends Controller
{
    private $title;
    private $module;
    private $repository;
    private $parent;
    private $addRatingToTestimonialUseCase;

    public function __construct(
        TestimonialRepository $testimonialRepository,
        AddRatingToTestimonialUseCase $addRatingToTestimonialUseCase
    )
    {
        $this->module = 'testimonials';
        $this->title = trans('testimonials.testimonials');
        $this->repository = $testimonialRepository;
        $this->parent = ParentEnum::ADMIN;
        $this->addRatingToTestimonialUseCase = $addRatingToTestimonialUseCase;
    }

    public function getIndex()
    {
        $data['module'] = $this->module;
        $data['page_title'] = trans('testimonials.List Testimonials');
        $data['breadcrumb'] = '';
        $data['rows'] = $this->repository->all();
        $data['activeTestimonialsCount'] = $this->repository->countActiveTestimonials();
        return view($this->parent . '.' . $this->module . '.index', $data);
    }

    public function getCreate()
    {
        $data['module'] = $this->module;
        $data['page_title'] = trans('app.Create') . " " . $this->title;
        $data['breadcrumb'] = [$this->title => route('admin.testimonials.get.index')];
        $data['row'] = '';
        return view($this->parent . '.' . $this->module . '.create', $data);
    }


    public function postCreate(CreateTestimonialRequest $request)
    {
        $status = $request->input('status');

        if ($status == 1) {
            $activeTestimonialsCount = $this->repository->countActiveTestimonials();

            if ($activeTestimonialsCount >= 7) {
                return redirect()->route('admin.testimonials.get.create')
                    ->withErrors(['message' => trans('testimonials.Cannot add more than 7 active testimonials.')])
                    ->withInput($request->all());
            }
        }

        $this->repository->create($request->all());
        return redirect()->route('admin.testimonials.get.index')->with('success', 'Testimonial created successfully.');
    }
    public function toggleStatus(Testimonial $testimonial)
    {
        if ($testimonial->status) {
            $testimonial->status = false;
        } else {
            $activeTestimonialsCount = $this->repository->countActiveTestimonials();
            if ($activeTestimonialsCount >= 7) {
                return redirect()->route('admin.testimonials.get.index')
                    ->withErrors(['message' => trans('testimonials.Deactivate another review to activate this one.')]);
            }
            $testimonial->status = true;
        }
        $testimonial->save();

        return redirect()->route('admin.testimonials.get.index')
            ->with('success', trans('testimonials.Testimonial status updated successfully'));
    }

    public function getRating()
    {
        $data['module'] = $this->module;
        $data['page_title'] = trans('testimonials.listRating');
        $data['breadcrumb'] = [$this->title => route('admin.testimonials.get.index')];
        $data['rows'] = $this->repository->allRating();
        $data['testimonialRepository'] = $this->repository;
        return view($this->parent . '.' . $this->module . '.listRating', $data);
    }

    public function addRatingToTestimonial(Rating $rating)
    {
        $response = $this->addRatingToTestimonialUseCase->execute($rating);

        if ($response['status'] === 'error') {
            return redirect($response['route'])->withErrors(['message' => $response['message']]);
        }

        return redirect($response['route'])->with('success', $response['message']);
    }

    public function deleteRating(Rating $rating)
    {
        try {
            $rating->delete();
            return redirect()->route('admin.testimonials.getRating')
                ->with('success', trans('testimonials.Rating deleted successfully'));
        } catch (\Exception $e) {
            return redirect()->route('admin.testimonials.getRating')
                ->withErrors(['message' => trans('testimonials.An error occurred while deleting the rating')]);
        }
    }
}
