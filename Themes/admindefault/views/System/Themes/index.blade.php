@extends('layouts.master')
@section('metatitle',trans('Langcore::themes.MainThemes'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_themes')}}
@endsection
@section('header')
	<link href="{{ themes('admindefault:css/modules/themes.css') }}" rel="stylesheet">
	<link href="/css/dropzone/dropzone.css" rel="stylesheet">
@endsection
@section('content')
@include('layouts.flash-message')
<div class="d-block mb-2">
	<button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#uploadmodule" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-cloud-upload-alt"></i> {{trans('Langcore::themes.UploadThemes')}}</button>
</div>
<div class="collapse {{ (Session::get('error') or $errors->any())? 'show' : ''}}" id="uploadmodule">
	<div class="card card-body text-center">
		{!!Form::open(['route' => ['upziptheme'], 'files' => true,'class'=>'dropzone','id'=>'dropzone'])!!}
		{!! Form::close() !!}
	</div>
</div>
<div id="managerthemes">
	<div class="row">
		@if($listthemes)
			@foreach($listthemes as $themes => $theme)
				@if($theme['type'] == 'web')
				<div class="col-sm-6 col-md-4">
					<div class="theme-card bg-white border rounded mb-3">
						<div class="theme-body rounded-top p-0">
							<div class="d-flex justify-content-center align-items-center rounded-top p-2 img-theme">
								@if(CFglobal::cfn('theme') == $theme['name'])
									<span class="active-theme rounded-circle"><i class="fas fa-check"></i></span>
								@endif
								<img src="{{($theme['image'])?'data:image/png;base64,'.$theme['image']:CFglobal::cfn('site_logo')}}" class="img-fluid">
								<span class="foldertheme badge badge-pill badge-dark"><i class="fas fa-folder-open"></i> {{$theme['name']}}</span>
							</div>
						</div>
						<div class="theme-footer px-3 py-2 rounded-bottom bg-dark text-white">
							<span class="d-block text-uppercase font-weight-bold">{{$theme['title']}}</span>
							@if($theme['description'])
							<small class="d-block text-muted mb-2">{{$theme['description']}}</small>
							@endif
							<div class="d-flex justify-content-between">
								<ul class="list-unstyled m-0">
									<li>{{trans('Langcore::global.author')}} {{$theme['author']}}</li>
									<li>{{trans('Langcore::global.version')}} {{$theme['version']}}</li>
								</ul>
								<div class="button my-2 text-right align-self-end">
									@if(CFglobal::cfn('theme') != $theme['name'])
										<button class="btn btn-pill btn-sm btn-primary active border border-white" type="button" aria-pressed="true" onclick="actionsys('{{ route('activetheme',$theme['name']) }}','#managerthemes');"><i class="fas fa-check"></i></button>
										<button class="btn btn-pill btn-sm btn-danger active border border-white" type="button" aria-pressed="true" onclick="actionsys('{{ route('deletetheme',$theme['name']) }}','#managerthemes');"><i class="fas fa-trash-alt"></i></button>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif
			@endforeach
		@endif
	</div>
</div>
@endsection
@section('footer')
<script src="/js/dropzone/dropzone.min.js"></script>
<script src="/js/dropzone/{{app()->getLocale()}}.js"></script>
<script type="text/javascript">
    Dropzone.options.dropzone = {
    	paramName: "filetheme",
        maxFilesize: 5,
		uploadMultiple: false,
		parallelUploads: 1,
        acceptedFiles: ".zip",
        addRemoveLinks: true,
        timeout: 5000,
        success: function(filemod, response) 
        {
        	new PNotify({
                title: "Done",
                text: "{{trans('Langcore::themes.SuccessUploadTheme')}}",
                type: "success",
            });
        	$('#managerthemes').load(window.location.href + " #managerthemes > *");
        },
        error: function(filemod, response)
        {
        	new PNotify({
                title: "Error",
                text: response,
                type: "warning"
            });
        	return false;
        }
	};
</script>
@endsection