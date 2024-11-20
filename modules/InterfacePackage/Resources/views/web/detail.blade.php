@extends('layouts.master')
@section('breadcrumbs')
{{Breadcrumbs::render('module_interfacepackage_detail',$interface)}}
@endsection
@section('header')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
@livewireStyles
@endsection
@section('content')
@include('layouts.flash-message')
@livewire('detailinterfaces',['interface'=>$interface])
@endsection
@section('footer')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@livewireScripts
@endsection