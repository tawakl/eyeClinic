@extends('layouts.app')
@section('styles')
    @stack('css')
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet"/>
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link id="pagestyle" href="/assets/css/argon-dashboard.css?v={{rand(1,999)}}" rel="stylesheet"/>
@endsection

@section('body_class','g-sidenav-show bg-gray-100')
@section('page')
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    @include('admin.partials.navigation')
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.partials.header')
        <div class="container-fluid py-4">
            @include('flash::message')
            @yield('content')
            <footer class="footer pt-3">
                @include('admin.partials.footer')
            </footer>
        </div>
    </main>
@endsection
@section('scripts')
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/dragula/dragula.min.js"></script>
    <script src="/assets/js/plugins/jkanban/jkanban.js"></script>
    <script src="/assets/js/plugins/chartjs.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="/assets/js/argon-dashboard.min.js?v=2.0.5"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="/assets/js/core/jquery.nicescroll.js"></script>
    <script>
        $("aside").niceScroll({
            cursorcolor: "#276567"
        })
        $("document").ready(function () {
            setTimeout(function () {
                $("div.alert").remove();
            }, 3000); // 5 secs

        });
    </script>
    @stack('js')
@endsection

