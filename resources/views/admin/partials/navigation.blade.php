<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 bg-white
@if(LaravelLocalization::getCurrentLocale()=='de' or LaravelLocalization::getCurrentLocale()=='en') fixed-start ms-4 @else fixed-end me-4 rotate-caret @endif"
       id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
           aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="" target="_blank">
            <img src="/assets/img/9867833.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">{{ trans('app.app name') }} </span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">

            {{-- Home --}}
            <li class="nav-item">
                <a class="nav-link {{ getActiveElementByRoute(route:'admin.dashboard') }}"
                   href="{{ route('admin.dashboard') }}">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="fa fa-home text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ trans('app.Home') }}</span>
                </a>
            </li>

            {{-- Gallery --}}
            <li class="nav-item">
                <a class="nav-link {{ getActiveElementByRoute(route:'admin.gallery.index') }}"
                   href="{{ route('admin.gallery.index') }}">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="fa fa-image text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">
                        {{ trans('navigation.gallery') }}
                        @if(isset($galleryCount)) <span class="badge bg-primary ms-2">{{ $galleryCount }}</span> @endif
                    </span>
                </a>
            </li>

            {{-- Clinic Working Days --}}
            <li class="nav-item">
                <a class="nav-link {{ getActiveElementByRoute(route:'admin.clinicWorkingDays.index') }}"
                   href="{{ route('admin.clinicWorkingDays.index') }}">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="fa fa-calendar-day text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ trans('navigation.clinicWorkingDays') }}</span>
                </a>
            </li>

            {{-- Clinic Closing Periods --}}
            <li class="nav-item">
                <a class="nav-link {{ getActiveElementByRoute(route:'admin.clinicClosingPeriods.edit') }}"
                   href="{{ route('admin.clinicClosingPeriods.edit') }}">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="fa fa-calendar-times text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ trans('navigation.clinicClosingPeriods') }}</span>
                </a>
            </li>

            {{-- Team --}}
            <li class="nav-item">
                <a class="nav-link {{ getActiveElementByRoute(route:'admin.team.index') }}"
                   href="{{ route('admin.team.index') }}">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="fa fa-users text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">
                        {{ trans('navigation.team') }}
                        @if(isset($teamCount)) <span class="badge bg-primary ms-2">{{ $teamCount }}</span> @endif
                    </span>
                </a>
            </li>
            {{-- Publication --}}
            <li class="nav-item">
                <a class="nav-link {{ getActiveElementByRoute(route:'admin.publication.index') }}"
                   href="{{ route('admin.publication.index') }}">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="fa fa-users text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">
                        {{ trans('navigation.publications') }}
                        @if(isset($publicationCount)) <span class="badge bg-primary ms-2">{{ $publicationCount }}</span> @endif
                    </span>
                </a>
            </li>

            {{-- Booking --}}
            <li class="nav-item">
                <a class="nav-link {{ getActiveElementByRoute(route:'admin.booking.index') }}"
                   href="{{ route('admin.booking.index') }}">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="fa fa-book text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">
                        {{ trans('navigation.booking') }}
                        @if(isset($bookingCount)) <span class="badge bg-primary ms-2">{{ $bookingCount }}</span> @endif
                    </span>
                </a>
            </li>

            {{-- Contact Settings (example, commented) --}}
            {{--
            <li class="nav-item">
                <a class="nav-link {{ getActiveElementByRoute(route:'admin.configs.get.edit') }}"
                   href="{{ route('admin.configs.get.edit') }}">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="fa fa-cogs text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ trans('navigation.contact_setting') }}</span>
                </a>
            </li>
            --}}

        </ul>
    </div>

    {{-- Optional Footer Illustration --}}
    {{--
    <div class="sidenav-footer mx-3 my-3">
        <div class="card card-plain shadow-none" id="sidenavCard">
            <img class="w-60 mx-auto" src="/assets/img/pexels-pavel-danilyuk-5996746.jpg" alt="sidebar_illustration">
        </div>
    </div>
    --}}
</aside>
