@extends('layouts.master')
@section('metatitle',trans('Langcore::global.Config'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_userconfig_main')}}
@endsection
@push('link')
@endpush
@section('content')
@include('layouts.flash-message')
{!!Form::open(['method' => 'POST', 'route' => 'userconfig.admin.main', 'enctype'=> 'multipart/form-data'])!!}
<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-body">
				<div class="form-group">
					{!!Form::label('subdomain', 'Sub Domain');!!}
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">https://</span>
						</div>
						{!! Form::text('subdomain', UserSetting::cfn('subdomain'), ['class' => 'form-control text-right','id'=>'subdomain','aria-describedby'=>'dotdomain','placeholder'=>'subdomain','aria-label'=>'subdomain']) !!}
						<div class="input-group-append">
							<span class="input-group-text" id="dotdomain">.vsmartweb.com</span>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6"></div>
</div>
<button class="btn btn-sm btn-primary" type="submit">
	<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
</button>
{!! Form::close() !!}
@endsection
@push('scripts')
@endpush