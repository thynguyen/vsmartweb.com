@extends('installer::web.master')
@section('header')
<link rel="stylesheet" href="{{ asset('installer/css/style.css') }}">
@endsection
@section('content')
<div class="container-fluid bg-white">
    <main role="main" class="ml-sm-auto pb-5 px-md-4 text-left">
		<div class="text-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">{!!trans('Langcore::installer.LicenseCode')!!}</h1>
		</div>
		@include('installer::web.flash-message')
		{!!Form::open(['method' => 'POST', 'route' => ['installer.web.checklicense'], 'enctype'=> 'multipart/form-data'])!!}
			<div class="form-group">
				{!! Form::text('WEB_KEY', old('WEB_KEY'), ['class' => 'form-control','id'=>'license','placeholder'=>'XXXX-XXXX-XXXX-XXXX','required']) !!}
		    </div>
		    <div class="text-center">
		        <button type="submit" class="btn btn-sm btn-primary">Kiểm tra</button>
		    </div>
		{!! Form::close() !!}
    </main>
</div>
@endsection
@section('footer')
@endsection