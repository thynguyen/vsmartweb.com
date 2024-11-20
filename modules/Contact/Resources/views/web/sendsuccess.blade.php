@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('Contact','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('module_contact_main')}}
@endsection
@section('header')
<meta http-equiv = "refresh" content = "5; url={!!route('contact.web.main')!!}" />
@endsection
@section('content')
<div class="card">
	<div class="card-body text-center">
		{!!transmod('contact::NoteSendContactSuccessful')!!}
		<br>
		<div class="spinner-grow text-primary" role="status">
		  <span class="sr-only">Loading...</span>
		</div>
		<div class="spinner-grow text-secondary" role="status">
		  <span class="sr-only">Loading...</span>
		</div>
		<div class="spinner-grow text-success" role="status">
		  <span class="sr-only">Loading...</span>
		</div>
		<div class="spinner-grow text-danger" role="status">
		  <span class="sr-only">Loading...</span>
		</div>
	</div>
</div>
@endsection
@section('footer')
@endsection