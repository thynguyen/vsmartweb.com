@extends('layouts.master')
@section('metatitle',trans('Langcore::language.TranslateLang'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_translatelang')}}
@endsection
@section('header')
<link href="{{ themes('admindefault:css/modules/language.css') }}" rel="stylesheet">
<style type="text/css">
	.loading {
		display: inline-block;
		font-size: 0;
		width: 30px;
		height: 30px;
		margin-top: 5px;
		border-radius: 15px;
		padding: 0;
		border: 3px solid #20a8d8;
		border-bottom: 3px solid rgba(255,255,255,0.0);
		border-left: 3px solid rgba(255,255,255,0.0);
		background-color: transparent !important;
		animation-name: rotateAnimation;
		-webkit-animation-name: wk-rotateAnimation;
		animation-duration: 1s;
		-webkit-animation-duration: 1s;
		animation-delay: 0.2s;
		-webkit-animation-delay: 0.2s;
		animation-iteration-count: infinite;
		-webkit-animation-iteration-count: infinite;
	}
	.hide-loading {
		opacity: 0;
		-webkit-transform: rotate(0deg) !important;
		transform: rotate(0deg) !important;
		-webkit-transform: scale(0) !important;
		transform: scale(0) !important;
	}

	@keyframes rotateAnimation {
	0%   {transform: rotate(0deg);}
	100% {transform: rotate(360deg);}
	}
	@-webkit-keyframes wk-rotateAnimation {
	0%   {-webkit-transform: rotate(0deg);}
	100% {-webkit-transform: rotate(360deg);}
	}
</style>
@endsection
@section('content')
@include('layouts.flash-message')
<div class="card">
	<div class="card-body text-center">
		<div class="d-block mb-4">
			<img src="{{ asset('images/data-import.png') }}">
		</div>
		<div class="loading"></div>
		<div class="text-loading text-info text-uppercase font-weight-bold">{!!trans('Langcore::language.ImportSampleTranslation')!!}</div>
	</div>
</div>
@endsection
@section('footer')
<script type="text/javascript">
	var baseUrl = "{{ asset('images/flags') }}",
	    placeholder = "{!!trans('Langcore::language.ChooseLanguage')!!}"; 
</script>
<script src="{{ asset('js/modules/language.js') }}"></script>
<script type="text/javascript">getdatalang('{{$routegetdatalang}}');</script>
@endsection