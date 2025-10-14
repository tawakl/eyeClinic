<nav class="navbar navbar-main navbar-expand-lg  px-0 mx-4 shadow-none border-radius-xl z-index-sticky " id="navbarBlur"
     data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            @if(isset($breadcrumb))
                @include('admin.partials.breadcrumb')
            @endif
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group"></div>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">{{ auth()->user()?->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 me-sm-n4" aria-labelledby="dropdownMenuButton"
                        style="padding-left: 1rem !important;">
                        <li>
                            <a href="{{ route('admin.profile.get.edit') }}" class="nav-link" style="display: flex; align-items: center;">
                                <i class="fa fa-user-circle pull-right"></i>
                                <span class="text-center dropdown-text-color"
                                      style="padding-left: 5px;">{{ __('header.My Profile') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.profile.get.logout') }}" class="nav-link" style="display: flex; align-items: center;">
                                <i class="fas fa-sign-out-alt pull-right"></i>
                                <span class="text-center dropdown-text-color fix" style="padding-left: 5px;">{{ __('header.Logout') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
                @include('partials.langSwitch')
            </ul>
        </div>
    </div>
</nav>
