<body class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(count(LanguageFunc::GetAllLang())>=2)
                <div class="d-flex justify-content-end mb-2">
                    @foreach (LanguageFunc::GetAllLang() as $lang)
                    <a class="mx-1 badge badge-primary text-wrap p-1" href="{{ language()->back($lang['locale']) }}"> <img src="{{ asset('images/flags/'. $lang['flag'] .'.png') }}" alt="{{ $lang['name'] }}" width="22px" /></a>
                    @endforeach
                </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>  
    <script src="{{ themes('admindefault:js/jquery.min.js') }}"></script>
    <script src="{{ themes('admindefault:js/popper.min.js') }}"></script>
    <script src="{{ themes('admindefault:js/bootstrap.min.js') }}"></script>
    <script src="{{ themes('admindefault:js/pace.min.js') }}"></script>
    <script src="{{ themes('admindefault:js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ themes('admindefault:js/coreui.min.js') }}"></script>
    @yield('footer')
    @stack('scripts')
</body>