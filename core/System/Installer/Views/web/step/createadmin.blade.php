@extends('installer::web.master')
@section('header')
<link rel="stylesheet" href="{{ asset('installer/css/style.css') }}">
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-sm-3 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3 pb-5">
      	@GetMenu(6)
      </div>
    </nav>

    <main role="main" class="col-sm-9 ml-sm-auto pb-5 px-md-4 bg-white content-main text-left">
		<div class="text-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">{!!trans('Langcore::installer.AdminAccount')!!}</h1>
		</div>
		@include('installer::web.flash-message')
		{!!Form::open(['method' => 'POST', 'route' => ['installer.web.createadmin'], 'enctype'=> 'multipart/form-data'])!!}
		<div class="form-group">
			{!!Form::label('username', trans('Langcore::global.Account'),['class' =>'col-form-label']);!!}
			{!! Form::text('username', old('username'), ['class' =>'form-control','id'=>'username','required']) !!}
		</div>
		<div class="form-group">
			{!!Form::label('email', trans('Langcore::global.Email'),['class' =>'col-form-label']);!!}
			{!! Form::text('email', old('email'), ['class' =>'form-control','id'=>'email','required']) !!}
		</div>
		<div class="form-group">
			{!!Form::label('password', trans('Langcore::global.Password'),['class' =>'col-form-label']);!!}
			{!! Form::password('password', ['class' =>'form-control','id'=>'password','required']) !!}
            <div class="progress">
                <div class="progress-bar progress-bar-striped  progress-bar-animated jak_pstrength" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
		</div>
		<div class="form-group">
			{!!Form::label('password_confirmation', trans('Langcore::global.Password'),['class' =>'col-form-label']);!!}
			{!! Form::password('password_confirmation', ['class' =>'form-control','id'=>'password_confirmation','required']) !!}
			<span class="text-confirm"></span>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					{!!Form::label('lastname', trans('Langcore::global.Lastname'),['class' =>'col-form-label']);!!}
					{!! Form::text('lastname', old('lastname'), ['class' =>'form-control','id'=>'lastname']) !!}
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					{!!Form::label('firstname', trans('Langcore::global.Firstname'),['class' =>'col-form-label']);!!}
					{!! Form::text('firstname', old('firstname'), ['class' =>'form-control','id'=>'firstname']) !!}
				</div>
			</div>
		</div>
	    <div class="text-center">
			<button type="submit" class="btn btn-sm btn-primary">{{trans('Langcore::global.Save')}}</button>
		</div>
		{!! Form::close() !!}
    </main>
  </div>
</div>
@endsection
@section('footer')
<script type="text/javascript">
	function passwordStrength(password) {
		var msg = ['not acceptable', 'very weak', 'weak', 'standard', 'looks good', 'yeahhh, strong mate.'];
		var desc = ['0%', '20%', '40%', '60%', '80%', '100%'];
		var descClass = ['', 'bg-danger', 'bg-danger', 'bg-warning', 'bg-success', 'bg-success'];
		var score = 0;
		if (password.length > 6) score++;
		if ((password.match(/[a-z]/)) && (password.match(/[A-Z]/))) score++;
		if (password.match(/\d+/)) score++;
		if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;
		if (password.length > 10) score++;
		$(".jak_pstrength").removeClass(descClass[score-1]).addClass(descClass[score]).css( "width", desc[score] ).html(msg[score]);
	    console.log(desc[score]);
	}
	function passwordConfirm(passwordcf){
		var password = $('#password').val();
		if(passwordcf === password){
			$('button[type=submit]').prop('disabled', false);
			$('.text-confirm').html('<span class="badge badge-success">Good</span>');
		} else {
			$('.text-confirm').html('<span class="badge badge-danger">Passwords do not match.</span>');
		}
	}
	$(document).ready(function(){
        $("#password").keyup(function() {
			$('button[type=submit]').prop('disabled', true);
			passwordStrength($(this).val());
        });
        $("#password_confirmation").keyup(function() {
			$('button[type=submit]').prop('disabled', true);
			passwordConfirm($(this).val());
        });
    });
</script>
@endsection