@extends('layouts.master')
@section('metatitle',$page->title)
@section('breadcrumbs')
{{Breadcrumbs::render('admin_pages_editor',$page)}}
@endsection
@section('header')
<link rel="stylesheet" type="text/css" href="{{ asset('modules/css/pages/adminpages.css.php') }}">
@livewireStyles
@endsection
@section('content')
@include('layouts.flash-message')
{!!Form::open(['method' => 'POST', 'route' => ['pages.admin.addcontent','id'=>$page->id], 'enctype'=> 'multipart/form-data'])!!}
<div class="card">
	<div class="card-body">
	{!!CKediter::ckediter('html',($page->content)?json_decode($page->content->content):'')!!}
	</div>
	<div class="card-footer">
		<button class="btn btn-sm btn-primary" type="submit">
			<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
		</button>
	</div>
</div>
{!! Form::close() !!}
@endsection
@section('footer')
@livewireScripts
<script src="{{ asset('modules/js/pages/adminpages.js.php') }}"></script>
{!!CKediter::ckediterjs('html',300)!!}
@endsection