@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('ServicePack','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_servicepack_main')}}
@endsection
@section('header')
@livewireStyles
@endsection
@section('content')
@include('layouts.flash-message')
@livewire('servicepack')
@endsection
@section('footer')
<script src="{{ asset('modules/js/servicepack/adminservicepack.js.php') }}"></script>
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
@livewireScripts
@endsection