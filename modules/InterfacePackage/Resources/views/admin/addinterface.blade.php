@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('InterfacePackage','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_interfacepackage_addinterface',$interface)}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<add-interface></add-interface>
@endsection
@section('footer')
<script src="{{ asset('js/app.js') }}" defer></script>
@endsection