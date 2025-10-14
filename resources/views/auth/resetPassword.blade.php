@extends('layouts.admin_auth_layout')

@section('body_class','login')

@section('content')
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/reset-cover.jpg'); background-position: top;">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-7">{{ trans('auth.Reset Password') }}</h1>
                        <p class="text-lead text-white"> @include('flash::message')</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card mb-md-8">
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="icon icon-shape bg-primary shadow text-center border-radius-md">
                                    <i class="ni ni-circle-08 text-white text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">{{ trans('auth.Cant log in?') }}</h5>
                                    <p class="text-sm mb-0">{{ trans('auth.Restore access to your account') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ Form::open(['route'=>'auth.post.resetPassword']) }}
                                <label>{{ trans('auth.We will send a recovery link to') }}</label>
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                       placeholder="{{ trans('app.email') }}" aria-label="Email">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if (!$errors->isEmpty())
                                <div class="alert alert-danger" role="alert">
                                    {!! $errors->first() !!}
                                </div>
                            @endif
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary w-100 mt-4 mb-0">{{ trans('auth.Reset password') }}</button>
                                    <p class="text-sm mt-3 cursor-pointer mb-0"></p>
                                </div>
                            {{ Form::close() }}
                        </div>
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <p class="mb-4 text-sm mx-auto">
                                <a href="{{ route('auth.get.login') }}" class="text-primary text-gradient font-weight-bold">{{ trans('auth.go_to_login_page') }}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="footer py-5">
        <div class="card">
            <div class="container-fluid">
                @if(LaravelLocalization::getCurrentLocale() === 'en')

                    made with <i class="text-danger fa fa-heart"></i> by
                    <a href="" class="font-weight-bold" target="_blank">{{__('app.app name') }}</a>
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    .
                @else

                    تم التطوير بواسطه
                    <a href="" class="font-weight-bold" target="_blank">{{__('app.app name') }}</a>
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    .
                @endif
            </div>
        </div>

        </div>
    </footer>
@endsection
@section('styles')
    @parent
    <link href="{{asset('css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('css/nucleo-svg.css')}}" rel="stylesheet" />

@endsection

