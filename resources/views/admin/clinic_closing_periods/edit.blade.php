@extends('layouts.admin_layout')

@push('title')
    {{ @$page_title }}
@endpush

@section('title', @$page_title)

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ trans('clinic_working_days.edit_closing_period') ?? 'Clinic Closing Period' }}</h5>
            </div>

            <div class="card-body">
                <div class="col-md-12 col-sm-12 col-xs-12 x_panel">
                    <form method="POST" action="{{ route('admin.clinicClosingPeriods.update') }}" class="form-vertical form-label-left">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            @include('admin.clinic_closing_periods.form', ['row' => $row])

                            <div class="form-group mt-3">
                                <div class="form-layout-footer">
                                    <button type="submit" class="btn btn-success">{{ trans('app.Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
