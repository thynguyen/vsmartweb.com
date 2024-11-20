@extends('layouts.master')
@section('metatitle',lang('content.config_site'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_configsite')}}
@endsection
@section('footer')
{!!CKediter::ckediterjs('site_warning')!!}
<div class="modal fade" id="configimg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
@endsection
@section('content')
@include('layouts.flash-message')
		<div class="card card-accent-primary">
			<div class="card-header">
				{{ lang('content.config_site') }}
			</div>
			<div class="card-body">
				{!!Form::open(['method' => 'POST', 'route' => 'siteconfig', 'enctype'=> 'multipart/form-data'])!!}
				<div class="form-group">
					{!!Form::label('sitename', lang('content.sitename'), ['class' => 'form-col-form-label']);!!}
					{!! Form::text('sitename', CFglobal::cfn('sitename'), ['class' => $errors->has('sitename') ? 'form-control is-invalid' : 'form-control','id'=>'sitename']) !!}
					@if ($errors->has('sitename'))
					<div class="invalid-feedback">
						{{ $errors->first('sitename') }}
					</div>
					@endif
				</div>
				<div class="form-group">
					{!!Form::label('site_description', lang('content.site_description'), ['class' => 'form-col-form-label']);!!}
					{!! Form::text('site_description', CFglobal::cfn('site_description'), ['class' => 'form-control','id'=>'site_description']) !!}
				</div>
				<div class="form-group">
					{!!Form::label('site_keywords', lang('content.site_keywords'), ['class' => 'form-col-form-label']);!!}
					{!! Form::text('site_keywords', CFglobal::cfn('site_keywords'), ['class' => 'form-control','id'=>'site_keywords']) !!}
				</div>
				<div class="form-group">
					{!!Form::label('moddefault', lang('content.moddefault'), ['class' => 'form-col-form-label']);!!}
					{!!Form::select('moddefault', ['Index-Home'=>trans('Langcore::global.home')]+$listmod, (CFglobal::cfn('moddefault'))?CFglobal::cfn('moddefault'):'', ['class' => 'form-control', 'id'=>'moddefault'])!!}
				</div>
				<div class="form-group">
					{!!Form::label('site_warning', lang('content.site_warning'), ['class' => 'form-col-form-label']);!!}
					{!!CKediter::ckediter('site_warning',CFglobal::cfn('site_warning'))!!}
				</div>
				<button class="btn btn-sm btn-primary" type="submit">
					<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
				</button>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection