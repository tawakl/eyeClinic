@extends('layouts.admin_layout')
@push('title')
    {{ @$page_title }}
@endpush
@section('title', @$page_title)
@section('content')
    <div class="container-fluid py-4">

        <hr class="horizontal dark my-7">
    </div>
@endsection
@push('css')
    <style>
        .small-box {
            min-height: 100px;
            padding: 20px;
            color: #fff;
            border-radius: .25rem;
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            display: block;
            margin-bottom: 20px;
            position: relative;
        }
    </style>
@endpush
@push('js')

@endpush
