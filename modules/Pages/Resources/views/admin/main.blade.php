@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('Pages','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_pages_main')}}
@endsection
@section('header')
<link rel="stylesheet" type="text/css" href="{{ asset('modules/css/pages/adminpages.css.php') }}">
<link href="{{ themes('admindefault:css/jquery.tag-editor.css') }}" rel="stylesheet">
@livewireStyles
@endsection
@section('content')
@include('layouts.flash-message')
@livewire('pages')
@endsection
@section('footer')
@livewireScripts
<script src="{{ asset('modules/js/pages/adminpages.js.php') }}"></script>
<script src="{{ themes('admindefault:js/jquery.caret.min.js') }}"></script>
<script src="{{ themes('admindefault:js/jquery.tag-editor.min.js') }}"></script>
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<!-- <script type="text/javascript">
    window.onscroll = function(ev) {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            window.livewire.emit('load-more');
        }
    };
</script> -->
@endsection