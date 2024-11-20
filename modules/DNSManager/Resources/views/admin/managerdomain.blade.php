@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('DNSManager','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_dnsmanager_managerdomain',json_decode($zone,true)['result'])}}
@endsection
@section('header')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
@endsection
@section('content')
@include('layouts.flash-message')
<domain-manager zone="{{$zone}}"></domain-manager>
@endsection
@section('footer')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
@endsection