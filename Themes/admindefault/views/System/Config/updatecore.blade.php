@extends('layouts.master')
@section('metatitle',trans('Langcore::config.Update'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_updatecore')}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<div class="card">
	<div class="card-body text-center">
		{{trans('Langcore::config.CurrentVersion')}}: <span class="badge badge-success text-white">{{config('app.vswver')}}</span>
	</div>
</div>
@endsection
@section('footer')
@endsection