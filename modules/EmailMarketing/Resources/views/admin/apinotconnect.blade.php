@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('EmailMarketing','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_emailmarketing_main')}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<div class="alert alert-warning" role="alert">
	{!!transmod('EmailMarketing::ErrorConnectAPI')!!}
</div>
@endsection
@section('footer')
@endsection