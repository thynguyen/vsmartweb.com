@extends('installer::web.master')
@section('header')
<link rel="stylesheet" href="{{ asset('installer/css/style.css') }}">
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-sm-3 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3 pb-5">
      	@GetMenu(5)
      </div>
    </nav>

    <main role="main" class="col-sm-9 ml-sm-auto pb-5 px-md-4 bg-white content-main text-left">
		<div class="text-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">{!!trans('Langcore::global.Config')!!}</h1>
		</div>
		@include('installer::web.flash-message')
		{!!Form::open(['method' => 'POST', 'route' => ['installer.web.configenv'], 'enctype'=> 'multipart/form-data'])!!}
		{!! Form::hidden('ADMIN_PREFIX', 'admin') !!}
		{!! Form::hidden('SITE_CLOSURE_MODE', 0) !!}
		<div class="row">
			<div class="col-sm-8">
				<div class="form-group">
					{!!Form::label('appname', trans('Langcore::installer.AppName'),['class' =>'col-form-label']);!!}
					{!! Form::text('APP_NAME', (old('APP_NAME'))?old('APP_NAME'):'V-Smart Web', ['class' =>'form-control','id'=>'appname']) !!}
				</div>
				<div class="form-group">
					{!!Form::label('appurl', trans('Langcore::installer.AppUrl'),['class' =>'col-form-label']);!!}
					{!! Form::text('APP_URL', (old('APP_URL'))?old('APP_URL'):'http://localhost', ['class' =>'form-control','id'=>'appurl']) !!}
				</div>
				<div class="form-group">
					{!!Form::label('appenv', trans('Langcore::installer.AppEnvironment'),['class' =>'col-form-label']);!!}
					{!!Form::select('APP_ENV', $appenvironment, (old('APP_ENV'))?old('APP_ENV'):'production', ['class' => 'form-control', 'id'=>'appenv'])!!}
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card h-100">
					<div class="card-body">
						<div class="custom-control custom-switch">
							{!! Form::hidden('APP_DEBUG', (old('APP_DEBUG'))?old('APP_DEBUG'):'cfg_yes', ['id'=>'val_app_debug']) !!}
							<input type="checkbox" class="custom-control-input" id="app_debug" checked>
							<label class="custom-control-label" for="app_debug">{{trans('Langcore::installer.AppDebug')}}</label>
						</div>
						<div class="custom-control custom-switch">
							{!! Form::hidden('LARAVEL_PAGE_SPEED_ENABLE', (old('LARAVEL_PAGE_SPEED_ENABLE'))?old('LARAVEL_PAGE_SPEED_ENABLE'):'cfg_yes', ['id'=>'val_laravel_page_speed']) !!}
							<input type="checkbox" class="custom-control-input" id="laravel_page_speed" checked>
							<label class="custom-control-label" for="laravel_page_speed">Minify HTML</label>
						</div>
						<div class="custom-control custom-switch">
							{!! Form::hidden('JS_MINIFIER', (old('JS_MINIFIER'))?old('JS_MINIFIER'):'cfg_yes', ['id'=>'val_js_minifier']) !!}
							<input type="checkbox" class="custom-control-input" id="js_minifier" checked>
							<label class="custom-control-label" for="js_minifier">Minify JS</label>
						</div>
						<div class="custom-control custom-switch">
							{!! Form::hidden('CSS_MINIFIER', (old('CSS_MINIFIER'))?old('CSS_MINIFIER'):'cfg_yes', ['id'=>'val_css_minifier']) !!}
							<input type="checkbox" class="custom-control-input" id="css_minifier" checked>
							<label class="custom-control-label" for="css_minifier">Minify CSS</label>
						</div>
					</div>
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
    $('input[type=checkbox]').click(function(){
    	id = $(this).attr('id');
    	valid = '#val_'+id;
    	if ($(this).is(':checked')) {
        	$(valid).val('cfg_yes');
    	} else {
        	$(valid).val('cfg_no');
        }
    });
</script>
@endsection