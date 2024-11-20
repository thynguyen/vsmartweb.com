<?php
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')?"https://":"http://";
$link = $link.$_SERVER['HTTP_HOST'];
?>
@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ !empty(CFglobal::cfn('site_logo')) ? $link.CFglobal::cfn('site_logo') : themes('img/logo.png') }}" alt="{{ CFglobal::cfn('sitename') }}">
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ CFglobal::cfn('sitename') }}. @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
