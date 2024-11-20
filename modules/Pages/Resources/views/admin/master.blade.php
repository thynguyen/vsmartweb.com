<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('metatitle')</title>
        <link rel="shortcut icon" href="{!!CFglobal::cfn('site_favicon')!!}" type="image/x-icon">
        <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fontisto@v3.0.4/css/fontisto/fontisto.min.css"></i>
        <link href="{{ themes('admindefault:css/simple-line-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('css/weather-icons.min.css') }}" rel="stylesheet">
        @stack('link')
        @yield('header')
    </head>
	<body style="--builder-filemanager-height:0px;">
		@yield('content')
        <script type="text/javascript">
            var urlsite = '{{CFglobal::cfn('site_url')}}',vsw_filemanager = '{{URL::to('/').'/filemanager'}}', csrf_token = '{{csrf_token()}}', langsite = '{{app()->getLocale()}}', akeyfilemanager = '{{session('akayfilemanager')}}',userid = '{{Auth::user()->id}}';
        </script>
        <script src="{{ ThemesFunc::jsminifier('js/routesys.js') }}"></script>
        <script src="{{ themes('admindefault:js/jquery.min.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="{{ themes('admindefault:js/popper.min.js') }}"></script>
        <script src="{{ themes('admindefault:js/bootstrap.min.js') }}"></script>
        <script src="{{ themes('admindefault:js/pace.min.js') }}"></script>
        <script src="{{ themes('admindefault:js/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ themes('admindefault:js/coreui.min.js') }}"></script>
        <script src="{{ themes('admindefault:js/pnotify.custom.min.js') }}"></script>
        <script src="{{ ThemesFunc::jsminifier('js/select2/select2.min.js') }}"></script>
        <script src="{{ ThemesFunc::jsminifier('js/select2/i18n/'.app()->getLocale().'.js') }}"></script>
        <script src="{{ ThemesFunc::jsminifier('js/cleavejs/cleave.min.js') }}"></script>
        <script src="{{ ThemesFunc::jsminifier('js/system.js') }}"></script>
        @RoutesSys
		@yield('footer')
    	@stack('scripts')
	</body>
</html>