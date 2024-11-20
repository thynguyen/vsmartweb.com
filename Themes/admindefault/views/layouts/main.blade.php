<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include('layouts.header')
    <div class="app-body">
        @include('layouts.sidebar')
        <main class="main">
            <!-- Breadcrumb-->
            <ol class="breadcrumb">
                @yield('breadcrumbs')
                <!-- Breadcrumb Menu-->
                <li class="breadcrumb-menu d-md-down-none">
                    <div class="btn-group" role="group" aria-label="Button group">
                        <!-- <a class="btn" href="#"> <i class="icon-speech"></i> </a> -->
                        <a class="btn" href="{{ route('siteconfig') }}"> <i class="icon-settings"></i>  {{lang('content.settings')}}</a>
                        <a class="btn" href="{{ route('filemanager') }}"> <i class="icon-folder"></i>  {{trans('Langcore::global.filemanager')}}</a>
                    </div>
                </li>
            </ol>
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div id="app">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
    <footer class="app-footer mt-3">
        <div class="ml-auto">
            <a href="{!!decrypt(encuvsw())!!}" title="V-Smart Web" target="_black">{{config('app.vswver')}}</a>
            <span>&copy; All Rights Reserved.</span>
        </div>
    </footer>
    <script type="text/javascript">
        var urlsite = '{{CFglobal::cfn('site_url')}}',vsw_filemanager = '{{URL::to('/').'/filemanager'}}', csrf_token = '{{csrf_token()}}', langsite = '{{LaravelLocalization::getCurrentLocale()}}', akeyfilemanager = '{{session('akayfilemanager')}}',userid = '{{Auth::user()->id}}';
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
    <script>
        window._locale = '{{ LaravelLocalization::getCurrentLocale() }}';
        window._translations = {!! cache('translations') !!};
    </script>
    @yield('footer')
    @stack('scripts')
</body>