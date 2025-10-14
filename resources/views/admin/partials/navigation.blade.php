<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 bg-white
@if(LaravelLocalization::getCurrentLocale()=='de' or LaravelLocalization::getCurrentLocale()=='en') fixed-start ms-4 @else fixed-end me-4 rotate-caret @endif "
       id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
           aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="" target="_blank">
            <img src="/assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">{{ trans('app.app name') }} </span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item ">
                <a class="nav-link {{getActiveElementByRoute(route:'admin.dashboard')}}"
                   href="{{ route('admin.dashboard') }}">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="fa fa-home text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1"> {{ trans('app.Home') }} </span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link {{getActiveElementByRoute(route:'admin.users.get.index')}}"
                   href="{{ route('admin.users.get.index') }}">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="fa fa-users text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ trans('navigation.users') }}</span>
                </a>
            </li>

{{--            <li class="nav-item ">--}}
{{--                <a class="nav-link {{getActiveElementByRoute(route:'admin.contact.get.index')}}"--}}
{{--                   href="{{ route('admin.contact.get.index') }}">--}}
{{--                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">--}}
{{--                        <i class="ni ni-mobile-button text-primary text-sm opacity-10"></i>--}}
{{--                    </div>--}}
{{--                    <span class="nav-link-text ms-1"> {{ trans('navigation.Contact') }} </span>--}}
{{--                </a>--}}
{{--            </li>--}}


        </ul>
    </div>
    <div class="sidenav-footer mx-3 my-3">
        <div class="card card-plain shadow-none" id="sidenavCard">
            <img class="w-60 mx-auto" src="/assets/img/navigation-icon.png" alt="sidebar_illustration">
        </div>
    </div>
</aside>
