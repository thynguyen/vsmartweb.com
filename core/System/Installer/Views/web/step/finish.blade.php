@extends('installer::web.master')
@section('header')
<link rel="stylesheet" href="{{ asset('installer/css/style.css') }}">
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-sm-3 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3 pb-5">
      	@GetMenu(7)
      </div>
    </nav>

    <main role="main" class="col-sm-9 ml-sm-auto pb-5 px-md-4 bg-white content-main text-left">
		<div class="text-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">{!!trans('Langcore::installer.CompleteInstallation')!!}</h1>
		</div>
		@if(!empty($messenger['useradmin']))
		<dl class="row">
			<dt class="col-sm-3">{{trans('Langcore::global.Account')}}</dt>
			<dd class="col-sm-9">{{$messenger['useradmin']['username']}}</dd>
			<dt class="col-sm-3">{{trans('Langcore::global.Email')}}</dt>
			<dd class="col-sm-9">{{$messenger['useradmin']['email']}}</dd>
			<dt class="col-sm-3">{{trans('Langcore::global.Password')}}</dt>
			<dd class="col-sm-9">{{$messenger['useradmin']['password']}}</dd>
		</dl>
		<hr>
		@endif
		@if(!empty($messenger['connectsql']))
		<div class="bg-dark" style="line-height: 1;"><pre class="text-white p-3"><code>{!!$messenger['connectsql']!!}</code></pre></div>
		@endif
		{!!Form::open(['method' => 'POST', 'route' => ['installer.web.finish'], 'enctype'=> 'multipart/form-data'])!!}
	    <div class="text-center">
			<button type="submit" class="btn btn-sm btn-primary">{!!trans('Langcore::installer.CompleteInstallation')!!}</button>
		</div>
		{!! Form::close() !!}
    </main>
  </div>
</div>
@endsection
@section('footer')
@endsection