@extends('layouts.master')
@section('metatitle',transmod('InterfacePackage::Category'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_interfacepackage_category',$category)}}
@endsection
@section('header')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
@endsection
@section('content')
@include('layouts.flash-message')
<category catid="{{$category['id']}}" listicon="{{$listicon}}"></category>
@endsection
@section('footer')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
@endsection