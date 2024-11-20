@extends('layouts.master')
@section('metatitle',trans('Langcore::language.ImportLanguage'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_importlang')}}
@endsection
@section('header')
<link href="{{ themes('admindefault:css/modules/language.css') }}" rel="stylesheet">
<link href="/css/dropzone/dropzone.css" rel="stylesheet">
@endsection
@section('content')
@include('layouts.flash-message')
{!!Form::open(['route' => ['upziplang'], 'files' => true,'class'=>'dropzone','id'=>'dropzone'])!!}
{!! Form::close() !!}
@endsection
@section('footer')
<script src="/js/dropzone/dropzone.min.js"></script>
<script src="/js/dropzone/{{app()->getLocale()}}.js"></script>
<script type="text/javascript">
    Dropzone.options.dropzone = {
    	paramName: "filelang",
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
</script>
@endsection