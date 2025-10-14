@extends('layouts.admin_layout')
@push('title')
    {{ @$page_title }}
@endpush
@section('title', @$page_title)

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-auto col-8 my-auto">
                        <div class="h-100">
                            <h5 class="mb-0">{{ trans('contact.view_contact_details') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-4" id="basic-course-info">
                <div class="card-body p-3">

                    <ul class="list-group">
                            <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                <strong class="text-dark">{{ trans('contact.visitor_name') }} : </strong>
                                &nbsp; {{ $row->visitor_name }}
                            </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">{{ trans('contact.email') }} :</strong>
                            {{ $row->email}}
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">{{ trans('contact.mobile') }} :</strong>
                            <span dir="ltr">{{ $row->phone }}</span>
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">{{ trans('contact.subject')  }} :</strong>
                            {{ $row->subject}}
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">{{ trans('contact.message')  }} :</strong>
                            {!! nl2br(e($row->message)) !!}
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">{{ trans('contact.created on') }} :</strong>
                            {{ $row->created_at}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
@endsection
