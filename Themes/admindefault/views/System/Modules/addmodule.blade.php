@extends('layouts.master')
@section('metatitle',trans('Langcore::modules.AddModule'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_add_modules')}}
@endsection
@section('header')
	<link href="{{ themes('admindefault:css/modules/modules.css') }}" rel="stylesheet">
	<link href="/css/dropzone/dropzone.css" rel="stylesheet">
@endsection
@section('content')
<div class="d-flex justify-content-between mb-2">
	<button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#uploadmodule" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-cloud-upload-alt"></i> {{trans('Langcore::modules.UpModFile')}}</button>
    <button type="button" class="btn btn-sm btn-primary" onclick="samplemodule()">
       <i class="fas fa-download"></i> Download {!!trans('Langcore::modules.SampleModule')!!}
    </button>
    
</div>
<div class="collapse {{ (Session::get('error') or $errors->any())? 'show' : ''}}" id="uploadmodule">
	<div class="card card-body text-center">
		@include('layouts.flash-message')
		{!!Form::open(['route' => ['upzipmod'], 'files' => true,'class'=>'dropzone','id'=>'dropzone'])!!}
		{!! Form::close() !!}
	</div>
</div>
<div class="card card-accent-primary card-body text-center"><i class="fas fa-robot fa-2x"></i> Kho Modules chưa có Module nào được cập nhật</div>
@endsection
@section('footer')
<script src="/js/dropzone/dropzone.min.js"></script>
<script src="/js/dropzone/{{app()->getLocale()}}.js"></script>
<script type="text/javascript">
    Dropzone.options.dropzone = {
    	paramName: "filemod",
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
                text: "{{trans('Langcore::modules.SuccessUploadMod')}}",
                type: "success",
            });
        	window.location.href=response;
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
    function samplemodule(){
        window.location.href='{!!url('modules/Test.zip')!!}';
    }
</script>
@endsection