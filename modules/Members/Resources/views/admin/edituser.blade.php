@extends('layouts.master')
@section('metatitle',transmod('members::EditUser',['user'=>$infomem->username]))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_members_edituser',$infomem)}}
@endsection
@section('header')
<link rel="stylesheet" type="text/css" href="{{ asset('css/datetimepicker-master/jquery.datetimepicker.min.css') }}"/ >
<style type="text/css">
	#showchangepass {
		cursor: pointer;
		position: relative;
	}
	#showchangepass::after {
		font-family: "Font Awesome 5 Free";
		content: "\f151";
	    font-size: 22px;
	    position: absolute;
	    right: 20px;
	    top: 7px;
	}
	#showchangepass.collapsed::after {
		content: "\f150";
	}
</style>
@endsection
@section('content')
@include('layouts.flash-message')
{!!Form::open(['method' => 'POST', 'route' => ['members.admin.edituser','id'=>$infomem->id], 'enctype'=> 'multipart/form-data'])!!}
<div class="card card-accent-primary">
	<div class="card-header">
		<i class="fas fa-id-card mr-2"></i>{!!transmod('members::EditUser',['user'=>$infomem['username']])!!}
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group row">
					{!! Form::label('username',trans('Langcore::global.Username'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!!$infomem['username']!!}
					</div>
				</div>
				<div class="form-group row">
					{!!Html::decode(Form::label('firstname',trans('Langcore::global.FullName').'<span class="text-danger">(*)</span>', ['class' =>'col-sm-3 col-form-label']))!!}
					<div class="col-sm-9">
						<div class="row">
							<div class="col-sm-6">
								{!! Form::text('firstname', $infomem['firstname'], ['class' =>$errors->has('firstname') ? 'form-control is-invalid' : 'form-control','id'=>'firstname','placeholder'=>trans('Langcore::global.Firstname')]) !!}
								@if ($errors->has('firstname'))
				                <div class="invalid-feedback">{{ $errors->first('firstname') }}</div>
				                @endif
							</div>
							<div class="col-sm-6">
								{!! Form::text('lastname', $infomem['lastname'], ['class' =>$errors->has('lastname') ? 'form-control is-invalid' : 'form-control','id'=>'lastname','placeholder'=>trans('Langcore::global.Lastname')]) !!}
								@if ($errors->has('lastname'))
				                <div class="invalid-feedback">{{ $errors->first('lastname') }}</div>
				                @endif
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					{!! Html::decode(Form::label('email','Email<span class="text-danger">(*)</span>', ['class' =>'col-sm-3 col-form-label'])) !!}
					<div class="col-sm-9">
						{!! Form::email('email', $infomem['email'], ['class' =>$errors->has('email') ? 'form-control is-invalid' : 'form-control','id'=>'email']) !!}
						@if ($errors->has('lastname'))
		                <div class="invalid-feedback">{{ $errors->first('lastname') }}</div>
		                @endif
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('mobile',trans('Langcore::global.Mobile'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::tel('mobile', $infomem['mobile'], ['class' =>'form-control','id'=>'mobile']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('address',trans('Langcore::global.Address'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('address', $infomem['address'], ['class' =>'form-control','id'=>'address']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('gender',trans('Langcore::global.Gender'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!!Form::select('gender', ['N'=>'N/A','M'=>trans('Langcore::global.Male'),'F'=>trans('Langcore::global.Female')], $infomem['gender'], ['class' => 'form-control'])!!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('birthday',trans('Langcore::global.Birthday'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('birthday', $infomem['birthday'], ['class' =>'form-control','id'=>'birthday','autocomplete'=>'off']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('website','Website', ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('website', $infomem['website'], ['class' =>'form-control','id'=>'website']) !!}
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group row">
					{!! Form::label('avatar','Avatar', ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						<div class="row d-flex align-items-center">
							<div class="col-sm-6">
								{!! Form::hidden('avatar', $infomem['avatar'], ['id'=>'avatar']) !!}
								{!!Form::button('<i class="fas fa-image"></i> '.trans('Langcore::global.Choose'),['class' => 'btn btn-primary btn-block','id'=>'fmavatar','data-input'=>'avatar'])!!}
							</div>
							<div class="col-sm-6">
								<div class="d-block w-100 text-center border rounded p-2">
									<img id="showavatar" class="img-fluid" src="{!!$infomem['avatar']!!}">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('facebook','Facebook', ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('facebook', $infomem['facebook'], ['class' =>'form-control','id'=>'facebook']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('twitter','Twitter', ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('twitter', $infomem['twitter'], ['class' =>'form-control','id'=>'twitter']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('skype','Skype', ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('skype', $infomem['skype'], ['class' =>'form-control','id'=>'skype']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('youtube','Youtube', ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('youtube', $infomem['youtube'], ['class' =>'form-control','id'=>'youtube']) !!}
					</div>
				</div>
				<hr>
				<div class="form-group row">
					{!! Form::label('question',transmod('members::SecurityQuestion'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('question', $infomem['question'], ['class' =>'form-control','id'=>'question']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('answer',transmod('members::Answer'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('answer', $infomem['answer'], ['class' =>'form-control','id'=>'answer']) !!}
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-header">
		{!! transmod('members::AboutMember') !!}
	</div>
	<div class="card-body">
		{!!CKediter::ckediter('about',$infomem['about'])!!}
	</div>
</div>
<div class="card">
	<div class="card-header text-white bg-primary collapsed" id="showchangepass" data-toggle="collapse" data-target="#ChangePassword" aria-expanded="true"> 
		<strong>{!!transmod('members::Password')!!}</strong>
	</div>
	<div class="collapse" id="ChangePassword">
		<div class="card-body">
			<div class="form-group row">
				{!! Form::label('old_password',transmod('members::OldPassword'), ['class' =>'col-sm-3 col-form-label']) !!}
				<div class="col-sm-9">
					{!! Form::password('old_password', ['class' => $errors->has('old_password') ? 'form-control is-invalid' : 'form-control','id'=>'old_password']) !!}
					@if ($errors->has('old_password'))
					<div class="invalid-feedback">
						{{ $errors->first('old_password') }}
					</div>
					@endif
				</div>
			</div>
			<div class="form-group row">
				{!! Form::label('password',transmod('members::Password'), ['class' =>'col-sm-3 col-form-label']) !!}
				<div class="col-sm-9">
					{!! Form::password('password', ['class' => $errors->has('password') ? 'form-control is-invalid' : 'form-control','id'=>'password']) !!}
					@if ($errors->has('password'))
					<div class="invalid-feedback">
						{{ $errors->first('password') }}
					</div>
					@endif
				</div>
			</div>
			<div class="form-group row">
				{!! Form::label('password-confirm',transmod('members::ConfirmPassword'), ['class' =>'col-sm-3 col-form-label']) !!}
				<div class="col-sm-9">
					{!! Form::password('password_confirmation', ['class' =>'form-control','id'=>'password-confirm']) !!}
				</div>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-footer">
		{!!Form::button('<i class="fas fa-save mr-2"></i>'.trans('Langcore::global.Save'),['class'=>'btn btn-primary btn-sm','type'=>'submit'])!!}
	</div>
</div>
{!! Form::close() !!}
@endsection
@section('footer')
	{!!CKediter::ckediterjs('about')!!}
	<script src="{{ asset('js/datetimepicker-master/jquery.datetimepicker.min.js') }}"></script>
	<script type="text/javascript">
		jQuery.datetimepicker.setLocale('{!!app()->getLocale()!!}');
		jQuery('#birthday').datetimepicker({
			timepicker:false,
			mask:true,
			format:'d-m-Y'
		});
	</script>
@endsection