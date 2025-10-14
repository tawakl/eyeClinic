@extends('layouts.admin_layout')
@push('title')
    {{ @$page_title }}
@endpush
@section('title', @$page_title)
@section('content')
    <div class="row">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        @include('admin.promo_code._filter')
        @if(!$rows->isEmpty())
            <div class="card mt-3 pt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ trans('promo_codes.promo_codes_List') }}</h5>
                    @if($promoCodeOnLandingPage)
                        <p class="text-info text-center">
                            {{ trans('promo_codes.Only one code is displayed on the landing page') }}
                        </p>
                    @endif
                    <div>
                        <a href="{{ route('admin.promoCodes.get.create') }}"
                           class="btn btn-success">{{ trans('app.Create') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0 w-99">
                            <thead>
                            <tr>
                                <th class="text-center">{{ trans('promo_codes.code') }}</th>
                                <th class="text-center">{{ trans('promo_codes.discount type') }}</th>
                                <th class="text-center">{{ trans('promo_codes.value') }}</th>
                                <th class="text-center">{{ trans('promo_codes.valid from') }}</th>
                                <th class="text-center">{{ trans('promo_codes.valid to') }}</th>
                                <th class="text-center">{{ trans('promo_codes.promo code use product type') }}</th>
                                <th class="text-center">{{ trans('promo_codes.Is active') }}</th>
                                <th class="text-center">{{ trans('promo_codes.created on') }}</th>
                                <th class="text-center">{{ trans('promo_codes.Add_to_landing_page') }}</th>
                                <th class="text-center">{{ trans('promo_codes.Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr class="text-center">
                                    <td class="align-middle text-center pt-2">{{ $row->code  ?? ''}}</td>
                                    <td class="align-middle text-center pt-2">{{ $row->discount_type ?? '' }}</td>
                                    <td class="align-middle text-center pt-2">{{ $row->promo_code_value ?? '' }}</td>
                                    <td class="align-middle text-center pt-2">{{ $row->from ?? '' }}</td>
                                    <td class="align-middle text-center pt-2">{{ $row->to ?? '' }}</td>
                                    <td class="align-middle text-center pt-2">{{ $row->promo_code_used_type ? trans('promo_codes.'.$row->promo_code_used_type) : trans('promo_codes.'.\App\Modules\PromoCodes\Enums\PromoCodesEnums::GENERAL_PROMO_CODE) }}</td>
                                    <td class="align-middle text-center pt-2">{!!  $row->is_active ? '<span class="label label-primary">'.trans('promo_codes.active') : '<span class="label label-danger">'.trans('promo_codes.not active') !!}</td>
                                    <td class="align-middle text-center pt-2">{{ $row->created_at }}</td>
                                    <td>

                                        @if ($row->is_active && $row->promo_code_type != \App\Modules\PromoCodes\Enums\PromoCodesEnums::FOR_SPECIFIC_STUDENTS)
                                            @if ($row->is_on_landing_page)
                                                <form action="{{ route('admin.promoCodes.remove-from-landing-page', $row->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger"
                                                            title="{{ trans('promo_codes.remove from landing page') }}">
                                                        {{trans('promo_codes.remove from landing page')}}
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.promoCodes.add-to-landing-page', $row->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-primary"
                                                            title="{{trans('promo_codes.add to landing page')}}">
                                                        {{trans('promo_codes.add to landing page')}}
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="align-middle text-center pt-5">
                                        <div class="row" style="text-align: center; margin-left: 4px;">
                                            <div class="col-md-3 col-sm-3 col-xs-3 form-group">
                                                <a class="btn btn-xs btn-info"
                                                   href="{{  route('admin.promoCodes.get.edit',$row->id) }}"
                                                   data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                   title="{{ trans('app.edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-3 form-group">
                                                <a class="btn btn-xs btn-info"
                                                   href="{{  route('admin.promoCodes.get.view',$row->id) }}"
                                                   data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                   title="{{ trans('app.view') }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>

                                            @if($row->promo_code_type === \App\Modules\PromoCodes\Enums\PromoCodesEnums::FOR_SPECIFIC_STUDENTS)
                                                <div class="col-md-3 col-sm-3 col-xs-3 form-group">
                                                    <a class="btn btn-xs btn-primary"
                                                       href="{{  route('admin.promoCodes.get.view_details_for_specific_student',$row->id) }}"
                                                       data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                       title="{{ trans('app.view_details_for_promo_code') }}">
                                                        <i class="fa fa-users"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $rows->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="card mt-3 pt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ trans('promo_codes.promo_codes_List') }}</h5>
                    <div>
                        <a href="{{ route('admin.promoCodes.get.create') }}"
                           class="btn btn-success">{{ trans('app.Create') }}</a>
                    </div>
                </div>
            </div>
            @include('partials.noData')
        @endif
    </div>
@endsection
