@extends('layouts.master')
@section('metatitle',trans('Langcore::global.Login'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_members_main')}}
@endsection
@section('header')
@livewireStyles
@endsection
@section('content')
@include('layouts.flash-message')
@livewire('members')
@endsection
@section('footer')
<script src="{{ asset('modules/js/members/adminmembers.js.php') }}"></script>
@livewireScripts
    <!-- <script type="text/javascript">
        window.onscroll = function(ev) {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                window.livewire.emit('load-more');
            }
        };
   </script> -->
@endsection