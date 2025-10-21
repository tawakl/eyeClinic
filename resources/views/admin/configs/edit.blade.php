@extends('layouts.admin_layout')

@push('title')
    {{ @$page_title }}
@endpush

@section('title', @$page_title)

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{trans('config.contact_setting')}}</h5>
            </div>

            <div class="card-body">
                <div class="col-md-12">
                    <form method="post" action="{{ route('admin.configs.post.edit') }}" class="form-vertical form-label-left">
                        @csrf
                        @method('put')

                        @include('admin.configs.form')

                        <div class="form-group mt-3">
                            <div class="form-layout-footer">
                                <button type="submit" class="btn btn-success"> {{ trans('app.Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
