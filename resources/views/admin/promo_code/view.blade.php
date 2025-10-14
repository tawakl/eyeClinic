@extends('layouts.admin_layout')
@push('title')
    {{ @$page_title }}
@endpush
@section('title', @$page_title)
@section('content')
    <div class="row mb-5">
        <div class="col-lg-12 mt-lg-0 mt-4">
            <!-- Card Profile -->
            <div class="card card-body" style="margin-top: 20px!important;">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-auto col-8 my-auto">
                        <div class="h-100">
                            <h5 class="mb-1 font-weight-bolder">
                                {{ $row->code}}
                            </h5>
                        </div>
                    </div>
                    <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                        <div class="form-check form-switch ms-2">
                            <a href="{{ route('admin.promoCodes.get.edit',[$row->id]) }}"
                               class="btn btn-primary">{{ trans('app.Edit') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card Basic Info -->
            <div class="card mt-4" id="basic-info">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-md-8 d-flex align-items-center">
                            <h5>{{__('promo_codes.basic_info')}}</h5>
                        </div>

                    </div>
                </div>
                <div class="card-body p-3">
                    <hr class="horizontal gray-light my-4">
                    <ul class="list-group">
                        <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                            <strong class="text-dark">{{ trans('promo_codes.valid from') }} : </strong>
                            &nbsp; {{ $row->from}}
                        </li>
                        <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                            <strong class="text-dark">{{ trans('promo_codes.valid to') }} : </strong>
                            &nbsp; {{ $row->to}}
                        </li>
                        <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                            <strong class="text-dark">{{ trans('promo_codes.discount type') }} : </strong>
                            &nbsp; {!!  $row->discount_type !!}
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">{{ trans('promo_codes.promo code use product type') }} :</strong>
                            &nbsp; {{ $row->promo_code_used_type}}
                        </li>
                        @if($row->promo_code_used_type == \App\Modules\PromoCodes\Enums\PromoCodesEnums::FOR_SPECIFIC_COURSES && count($row->courses))
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">{{ trans('promo_codes.courses') }} :</strong>
                                <br>
                                @foreach($row->courses as $course)
                                    {{ $course->name }}<br>
                                @endforeach
                            </li>
                        @endif
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">{{ trans('promo_codes.value') }} :</strong>
                            &nbsp; {!!  $row->promo_code_value !!}
                        </li>

                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">{{ trans('promo_codes.count per student') }} :</strong>
                            &nbsp; {!! $row->count_per_student  !!}
                        </li>

                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">{{ trans('promo_codes.count for all students') }} :</strong>
                            &nbsp; {!!  $row->count_for_all_students !!}
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">{{ trans('promo_codes.Is active') }} :</strong>
                            &nbsp; {!!  $row->is_active ? '<span class="label label-primary">'.trans('promo_codes.active') : '<span class="label label-danger">'.trans('promo_codes.not active') !!}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
