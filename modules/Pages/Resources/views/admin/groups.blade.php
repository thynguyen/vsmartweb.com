@extends('layouts.master')
@section('metatitle',transmod('Pages::PageGroups'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_pages_groups')}}
@endsection
@section('header')
<link rel="stylesheet" type="text/css" href="{{ asset('modules/css/pages/adminpages.css.php') }}">
@livewireStyles
@endsection
@section('content')
@include('layouts.flash-message')
@livewire('allgroups')
@endsection
@section('footer')
@livewireScripts
<script src="{{ asset('modules/js/pages/adminpages.js.php') }}"></script>
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
@endsection