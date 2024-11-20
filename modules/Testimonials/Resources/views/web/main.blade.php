@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('Testimonials','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('module_testimonials_main')}}
@endsection
@section('header')
@if(env('RECAPTCHA_SECRET_KEY') && env('RECAPTCHA_SITE_KEY'))
@if(env('RECAPTCHA_VERSION')=='v2')
{!! htmlScriptTagJsApi(['lang'=>LaravelLocalization::getCurrentLocale()]) !!}
@elseif(env('RECAPTCHA_VERSION')=='v3')
{!! htmlScriptTagJsApi(['action' => 'submitcontact']) !!}
@endif
@endif
@endsection
@section('content')
@include('layouts.flash-message')
{!!Form::open(['method' => 'POST', 'route' => ['testimonials.web.addtestimonial'], 'enctype'=> 'multipart/form-data'])!!}
<div class="row">
	<div class="col-sm-3"> 
		<div class="d-flex justify-content-center align-items-center border rounded h-100 p-3" id="uploadavatar" style="cursor:pointer;">
	    	<img id="imagepreview" class="img-fluid" src="{!!asset('images/no-image.jpg')!!}" alt="Avatar" />
		</div>
		{!! Form::file('avatar', ['class' =>'d-none','onchange'=>'showImage(this);']) !!}
	</div>
	<div class="col-sm-9">
		<div class="form-group row">
			{!!Form::label('fullname', trans('Langcore::global.FullName'),['class' =>'col-sm-2 col-form-label']);!!}
			<div class="col-sm-10">
				{!! Form::text('fullname', old('fullname'), ['class' => $errors->has('fullname') ? 'form-control is-invalid' : 'form-control','id'=>'fullname','required']) !!}
				@if ($errors->has('fullname'))
                <div class="invalid-feedback">{{ $errors->first('fullname') }}</div>
                @endif
            </div>
		</div>
		<div class="form-group row">
			{!!Form::label('email', trans('Langcore::global.Email'),['class' =>'col-sm-2 col-form-label']);!!}
			<div class="col-sm-10">
				{!! Form::text('email', old('email'), ['class' => 'form-control','id'=>'email']) !!}
            </div>
		</div>
		<div class="form-group row">
			{!!Form::label('mobile', trans('Langcore::global.Mobile'),['class' =>'col-sm-2 col-form-label']);!!}
			<div class="col-sm-10">
				{!! Form::text('mobile', old('mobile'), ['class' => 'form-control','id'=>'mobile']) !!}
            </div>
		</div>
		<div class="form-group row">
			{!!Form::label('address', trans('Langcore::global.Address'),['class' =>'col-sm-2 col-form-label']);!!}
			<div class="col-sm-10">
				{!! Form::text('address', old('address'), ['class' => 'form-control','id'=>'address']) !!}
            </div>
		</div>
	</div>
</div>
<div class="form-group">
	{!!Form::label('testimonial', transmod('Testimonials::Opinion'),['class' =>'col-form-label']);!!}
	{!! Form::textarea('testimonial', old('testimonial'), ['class' => 'form-control','id'=>'testimonial','required','rows'=>5]) !!}
</div>
<div class="form-group">
	@CapchaSite()
	@if ($errors->has('g-recaptcha-response'))
    <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
    @endif
</div>
<button type="submit" class="btn btn-sm btn-primary">{!!trans('Langcore::global.Save')!!}</button>
{!! Form::close() !!}
@endsection
@section('footer')
<script type="text/javascript">
	$('#uploadavatar').click(function(e){
		$("input[type='file']").click();
	});
	function showImage(input) { 
		if (input.files && input.files[0]) { 
			var reader = new FileReader(); 
			reader.onload = function (e) { 
				$('#imagepreview').attr('src', e.target.result); 
			}
			reader.readAsDataURL(input.files[0]); 
		}
	}
</script>
@endsection