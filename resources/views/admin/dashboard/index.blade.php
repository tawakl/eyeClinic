@extends('layouts.admin_layout')
@push('title')
    {{ @$page_title }}
@endpush
@section('title', @$page_title)
@section('content')
    <div class="container-fluid py-4 d-flex flex-column justify-content-center align-items-center" style="min-height: 85vh;">
        <div class="text-center mb-4">
            <h3 class="text-dark fw-bold">Welcome to the Dashboard</h3>
            <p class="text-dark">Here you can manage all your site settings and track data easily.</p>
        </div>

        <div class="text-center">
            <img src="/assets/img/pexels-shvetsa-3846022.jpg"
                 alt="Dashboard"
                 class="img-fluid"
                 style="max-width: 650px; height: auto; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
        </div>
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
