@extends('layouts.app')

@section('page')

    @yield('content')

@endsection

@section('styles')
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <link id="pagestyle" href="/assets/css/argon-dashboard.css?v={{rand(1,999)}}" rel="stylesheet"/>
    @if(LaravelLocalization::getCurrentLocale() === 'ar')
        <link id="pagestyle" href="/assets/css/argon-dashboard.a.css?v={{rand(1,999)}}" rel="stylesheet"/>
    @endif
@endsection
