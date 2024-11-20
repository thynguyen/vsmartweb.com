@extends('installer::web.master')
@section('header')
<link rel="stylesheet" href="{{ asset('installer/css/style.css') }}">
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-sm-3 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3 pb-5">
      	@GetMenu(4)
      </div>
    </nav>

    <main role="main" class="col-sm-9 ml-sm-auto pb-5 px-md-4 bg-white content-main text-left">
		<div class="text-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">{!!trans('Langcore::installer.Database')!!}</h1>
		</div>
		@include('installer::web.flash-message')
		{!!Form::open(['method' => 'POST', 'route' => ['installer.web.database'], 'enctype'=> 'multipart/form-data'])!!}
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					{!!Form::label('dbconnection', trans('Langcore::installer.DatabaseConnection'),['class' =>'col-form-label']);!!}
					{!!Form::select('DB_CONNECTION', $dbconnection, old('DB_CONNECTION'), ['class' => 'form-control', 'id'=>'dbconnection'])!!}
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					{!!Form::label('dbhost', trans('Langcore::installer.DatabaseHost'),['class' =>'col-form-label']);!!}
					{!! Form::text('DB_HOST', (old('DB_HOST'))?old('DB_HOST'):'127.0.0.1', ['class' =>'form-control','id'=>'dbhost','required']) !!}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					{!!Form::label('dbport', trans('Langcore::installer.DatabasePort'),['class' =>'col-form-label']);!!}
					{!! Form::number('DB_PORT', (old('DB_PORT'))?old('DB_PORT'):'3306', ['class' =>'form-control','id'=>'dbport','required']) !!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
					{!!Form::label('dbdatabase', trans('Langcore::installer.DatabaseName'),['class' =>'col-form-label']);!!}
					{!! Form::text('DB_DATABASE', old('DB_DATABASE'), ['class' =>'form-control','id'=>'dbdatabase','required']) !!}
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					{!!Form::label('dbusername', trans('Langcore::global.Username'),['class' =>'col-form-label']);!!}
					{!! Form::text('DB_USERNAME', old('DB_USERNAME'), ['class' =>'form-control','id'=>'dbusername','required']) !!}
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					{!!Form::label('dbpassword', trans('Langcore::global.Password'),['class' =>'col-form-label']);!!}
					{!! Form::password('DB_PASSWORD', ['class' =>'form-control','id'=>'dbpassword','required']) !!}
				</div>
			</div>
		</div>
	    <div class="text-center">
			<button type="submit" class="btn btn-sm btn-primary">{{trans('Langcore::installer.Connection')}}</button>
		</div>
		{!! Form::close() !!}
    </main>
  </div>
</div>
@endsection
@section('footer')
@endsection