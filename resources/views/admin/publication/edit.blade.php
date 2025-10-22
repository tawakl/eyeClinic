@extends('layouts.admin_layout')

@push('title')
    {{ @$page_title }}
@endpush
@push('css')
    <link rel="stylesheet" type="text/css" href="/assets/css/select2.min.css">
@endpush

@section('title', @$page_title)

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ trans('publication.edit_publication') }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.publication.update', $row->id) }}" class="form-vertical form-label-left">
                    @csrf
                    @method('PUT')
                    @include('admin.publication.form', ['row' => $row])
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success">{{ trans('app.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="/assets/js/select2.full.min.js"></script>
    <script src="/assets/js/form-select2.min.js"></script>
@endpush
