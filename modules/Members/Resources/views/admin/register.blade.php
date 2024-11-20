@extends('layouts.master')
@section('metatitle',transmod('members::RegisterMember'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_members_register')}}
@endsection
@section('header')
<link rel="stylesheet" type="text/css" href="{{ asset('css/datetimepicker-master/jquery.datetimepicker.min.css') }}"/ >
@endsection
@section('content')
@include('layouts.flash-message')
{!!Form::open(['method' => 'POST', 'route' => ['members.admin.register'], 'enctype'=> 'multipart/form-data'])!!}
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group row">
					{!! Html::decode(Form::label('username',trans('Langcore::global.Username').'<span class="text-danger">(*)</span>', ['class' =>'col-sm-3 col-form-label'])) !!}
					<div class="col-sm-9">
						{!! Form::text('username', old('username'), ['class' => $errors->has('username') ? 'form-control is-invalid' : 'form-control','id'=>'username']) !!}
						@if ($errors->has('username'))
		                <div class="invalid-feedback">{{ $errors->first('username') }}</div>
		                @endif
					</div>
				</div>
				<div class="form-group row">
					{!! Html::decode(Form::label('firstname',trans('Langcore::global.FullName').'<span class="text-danger">(*)</span>', ['class' =>'col-sm-3 col-form-label'])) !!}
					<div class="col-sm-9">
						<div class="row">
							<div class="col-sm-6">
								{!! Form::text('firstname', old('firstname'), ['class' =>$errors->has('firstname') ? 'form-control is-invalid' : 'form-control','id'=>'firstname','placeholder'=>trans('Langcore::global.Firstname')]) !!}
								@if ($errors->has('firstname'))
				                <div class="invalid-feedback">{{ $errors->first('firstname') }}</div>
				                @endif
							</div>
							<div class="col-sm-6">
								{!! Form::text('lastname', old('lastname'), ['class' =>$errors->has('lastname') ? 'form-control is-invalid' : 'form-control','id'=>'lastname','placeholder'=>trans('Langcore::global.Lastname')]) !!}
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
						{!! Form::email('email', old('email'), ['class' =>$errors->has('email') ? 'form-control is-invalid' : 'form-control','id'=>'email']) !!}
						@if ($errors->has('lastname'))
		                <div class="invalid-feedback">{{ $errors->first('lastname') }}</div>
		                @endif
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('mobile',trans('Langcore::global.Mobile'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::tel('mobile', old('mobile'), ['class' =>'form-control','id'=>'mobile']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('address',trans('Langcore::global.Address'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('address', old('address'), ['class' =>'form-control','id'=>'address']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('avatar','Avatar', ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						<div class="row d-flex align-items-center">
							<div class="col-sm-6">
								{!! Form::hidden('avatar', old('avatar'), ['id'=>'avatar', 'onchange'=>"uploadimg('#avatar','#showavatar')"]) !!}
								{!!Form::button('<i class="fas fa-image"></i> '.trans('Langcore::global.Choose'),['class' => 'btn btn-primary btn-block','id'=>'fmavatar','data-input'=>'avatar','onclick'=>'open_popup("'.URL::to('/').'/filemanager/dialog.php?akey='.session('akayfilemanager').'&type=0&popup=1&field_id=avatar")'])!!}
							</div>
							<div class="col-sm-6">
								<div class="d-block w-100 text-center border rounded p-2">
									<img id="showavatar" class="img-fluid">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group row">
					{!! Form::label('gender',trans('Langcore::global.Gender'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!!Form::select('gender', ['N'=>'N/A','M'=>trans('Langcore::global.Male'),'F'=>trans('Langcore::global.Female')], old('gender'), ['class' => 'form-control'])!!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('birthday',trans('Langcore::global.Birthday'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('birthday', old('birthday'), ['class' =>'form-control','id'=>'birthday','autocomplete'=>'off']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('question',transmod('members::SecurityQuestion'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('question', old('question'), ['class' =>'form-control','id'=>'question']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('answer',transmod('members::Answer'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('answer', old('answer'), ['class' =>'form-control','id'=>'answer']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Html::decode(Form::label('password',transmod('members::Password').'<span class="text-danger">(*)</span>', ['class' =>'col-sm-3 col-form-label'])) !!}
					<div class="col-sm-9">
						{!! Form::password('password', ['class' => $errors->has('password') ? 'form-control is-invalid' : 'form-control','id'=>'password']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('password',transmod('members::ConfirmPassword'), ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::password('password_confirmation', ['class' =>'form-control','id'=>'password-confirm']) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group row">
					{!! Form::label('website','Website', ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('website', old('website'), ['class' =>'form-control','id'=>'website']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('facebook','Facebook', ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('facebook', old('facebook'), ['class' =>'form-control','id'=>'facebook']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('twitter','Twitter', ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('twitter', old('twitter'), ['class' =>'form-control','id'=>'twitter']) !!}
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group row">
					{!! Form::label('skype','Skype', ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('skype', old('skype'), ['class' =>'form-control','id'=>'skype']) !!}
					</div>
				</div>
				<div class="form-group row">
					{!! Form::label('youtube','Youtube', ['class' =>'col-sm-3 col-form-label']) !!}
					<div class="col-sm-9">
						{!! Form::text('youtube', old('youtube'), ['class' =>'form-control','id'=>'youtube']) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card-footer">
		{!!Form::button('<i class="fas fa-save mr-2"></i>'.trans('Langcore::global.Save'),['class'=>'btn btn-primary btn-sm','type'=>'submit'])!!}
	</div>
</div>
{!! Form::close() !!}
@endsection
@section('footer')
	<script src="{{ asset('js/datetimepicker-master/jquery.datetimepicker.min.js') }}"></script>
	<script type="text/javascript">
		jQuery('#birthday').datetimepicker({
			timepicker:false,
			mask:true,
			format:'d-m-Y'
		});
	</script>
@endsection