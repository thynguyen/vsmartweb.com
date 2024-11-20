@extends('layouts.master')
@section('metatitle',trans('Langcore::language.TranslateLang'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_addkeylang')}}
@endsection
@section('header')
<link href="{{ themes('admindefault:css/modules/language.css') }}" rel="stylesheet">
@endsection
@section('content')
@include('layouts.flash-message')
<div class="card card-body">
	{!!Form::open(['method' => 'POST', 'route' => ['addkeylang','locale'=>$locale,'group'=>$group], 'enctype'=> 'multipart/form-data'])!!}
	<div class="form-group">
		{!!Form::label('key', 'Key', ['class' => 'form-col-form-label']);!!}
		{!! Form::text('key', '', ['class' => 'form-control','id'=>'key']) !!}
	</div>
	<button class="btn btn-sm btn-primary" type="submit">
		<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
	</button>
	{!! Form::close() !!}
</div>
@endsection
@section('footer')
@endsection