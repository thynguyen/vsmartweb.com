@extends('layouts.master')
@section('metatitle',trans('Langcore::config.ConfigModule'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_emailmarketing_config')}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<div class="card">
	<div class="card-body">
		{!!Form::open(['method' => 'POST', 'route' => 'emailmarketing.admin.config', 'enctype'=> 'multipart/form-data'])!!}
			<div class="form-group">
				{!!Form::label('mailchimp_apikey', 'MAILCHIMP APIKEY');!!}
				{!! Form::text('MAILCHIMP_APIKEY', env('MAILCHIMP_APIKEY'), ['class' => $errors->has('mailchimp_apikey') ? 'form-control is-invalid' : 'form-control','id'=>'mailchimp_apikey']) !!}
			</div>
			<div class="form-group">
				{!!Form::label('mailchimp_list_id', 'MAILCHIMP LIST ID');!!}
				{!! Form::text('MAILCHIMP_LIST_ID', env('MAILCHIMP_LIST_ID'), ['class' => $errors->has('mailchimp_list_id') ? 'form-control is-invalid' : 'form-control','id'=>'mailchimp_list_id']) !!}
			</div>
			<button type="submit" class="btn btn-sm btn-primary">{!!trans('Langcore::global.Save')!!}</button>
		{!! Form::close() !!}
	</div>
</div>
@endsection
@section('footer')
@endsection