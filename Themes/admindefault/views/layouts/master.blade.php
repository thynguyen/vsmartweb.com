<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('metatitle')</title>
        <link rel="shortcut icon" href="{!!CFglobal::cfn('site_favicon')!!}" type="image/x-icon">
        <!-- Icons-->
        <link href="{{ themes('admindefault:css/coreui-icons.min.css') }}" rel="stylesheet">
        <link href="{{ themes('admindefault:css/flag-icon.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fontisto@v3.0.4/css/fontisto/fontisto.min.css"></i>
        <link href="{{ themes('admindefault:css/simple-line-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('css/weather-icons.min.css') }}" rel="stylesheet">
        <!-- Main styles for this application-->
        <link href="{{ themes('admindefault:css/style.css') }}" rel="stylesheet">
        <link href="{{ themes('admindefault:css/pace.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/pnotify.custom.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/select2-bootstrap.css') }}" rel="stylesheet" />
        @stack('link')
        @yield('header')
    </head>
    @if(Auth::check())
        @include('layouts.main')
    @else
        @include('layouts.guestmain')
    @endif
    @RoutesSys
</html>