<!DOCTYPE html>
<html lang="{{LaravelLocalization::getCurrentLocale()}}" dir="ltr">
<head>
    <meta charset=" utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('app.app name') }}  @stack('title')</title>


    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>

    @yield('styles')


</head>
<body class="@yield('body_class')">
{{--Page--}}
@yield('page')
{{--Scripts--}}
@yield('scripts')
</body>
</html>
