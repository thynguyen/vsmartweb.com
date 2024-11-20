@extends('layouts.master')
@section('metatitle',($module['active'])?trans('Langcore::global.EditMod'):trans('Langcore::global.ActiveMod'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_infomod_modules',($module['active'])?trans('Langcore::modules.EditMod'):trans('Langcore::modules.InfoMod'),$path)}}
@endsection
@section('header')
	<link href="{{ themes('admindefault:css/modules/modules.css') }}" rel="stylesheet">
	<link href="{{ themes('admindefault:css/jquery.fonticonpicker.min.css') }}" rel="stylesheet">
	<link href="{{ themes('admindefault:css/jquery.fonticonpicker.darkgrey.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@include('layouts.flash-message')
{!!Form::open(['method' => 'POST', 'route' => ['infomod','module'=>$path], 'enctype'=> 'multipart/form-data'])!!}		
{!!Form::hidden('active', 1)!!}
{!! Form::hidden('bgmod', $module['bgmod'], ['id'=>'bgmod', 'onchange'=>"uploadimg('#bgmod','#showimg')"]) !!}
<div class="row">
	<div class="col-sm-9">
		<div class="card card-accent-primary">
			<div class="card-body">
				<div class="form-group">
					{!!Form::label('title', trans('Langcore::global.Title'), ['class' => 'form-col-form-label']);!!}
					<div class="input-group">
						<div class="input-group-prepend">
							{!!$list_icons!!}
						</div>				
						{!! Form::text('title', $module['title'], ['class' => $errors->has('title') ? 'form-control ml-2 rounded-left is-invalid' : 'form-control ml-2 rounded-left','id'=>'title']) !!}
					</div>
					@if ($errors->has('title'))
					<div class="invalid-feedback">
						{{ $errors->first('title') }}
					</div>
					@endif
				</div>		
				<div class="form-group">
					{!!Form::label('description', trans('Langcore::global.Description'), ['class' => 'form-col-form-label']);!!}
					{!! Form::text('description', $module['description'], ['class' => $errors->has('description') ? 'form-control is-invalid' : 'form-control','id'=>'description']) !!}
				</div>		
				<div class="form-group">
					{!!Form::label('keywords', trans('Langcore::global.Keywords'), ['class' => 'form-col-form-label']);!!}
					{!! Form::text('keywords', $module['keywords'], ['class' => $errors->has('keywords') ? 'form-control is-invalid' : 'form-control','id'=>'keywords']) !!}
				</div>
				{!!Form::button('<i class="fas fa-dot-circle"></i> '.trans('Langcore::global.Save'),['class' => 'btn btn-primary btn-block', 'id'=>'submitinstall', 'type'=>'submit'])!!}
			</div>
		</div>
		@if($modjson)
		<div class="card card-accent-primary">
			<div class="card-body">
				<table class="table table-responsive-sm table-striped table-sm">
					<thead>
						<tr>
							<th>{!!trans('Langcore::modules.FuncName')!!}</th>
							<th>{!!trans('Langcore::modules.FunctionNameCustom')!!}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($modjson as $func => $customfunc)
						<tr>
							<td>{!!$func!!}</td>
							<td>
								{!! Form::text('func_custom['.$func.']', $customfunc, ['class' => 'form-control']) !!}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		@endif
	</div>
	<div class="col-sm-3">
		<div class="card card-accent-primary">
			<div class="card-header">
				{!!Form::label('bgmod', trans('Langcore::global.Background'), ['class' => 'form-col-form-label']);!!}
			</div>
			<div class="card-body">
				<div class="d-block w-100 text-center border rounded p-2">
					<img src="{!!($module['bgmod'])?$module['bgmod']:themes('img/noimage.png')!!}" id="showimg" class="img-fluid">
				</div>
				{!!Form::button('<i class="fas fa-image"></i> '.trans('Langcore::global.Choose'),['class' => 'btn btn-primary btn-block mt-2','id'=>'lfm','data-input'=>'bgmod','onclick'=>'open_popup("'.URL::to('/').'/filemanager/dialog.php?akey='.session('akayfilemanager').'&type=0&popup=1&field_id=bgmod")'])!!}
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
@endsection
@section('footer')
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        	<div class="modal-body"></div>
        </div>
    </div>
</div>
	<script src="{{ themes('admindefault:js/jquery.fonticonpicker.min.js') }}"></script>
	<script type="text/javascript">
		$("#iconvalue").fontIconPicker({ theme: 'fip-darkgrey' });
		$('form').submit(function (e) {
			$('#submitinstall').prop( "disabled", true ).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Installing...');
			@if(!$module)
			e.preventDefault();

			var form = $(this);
			var url = form.attr('action');
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				success: function(data)
				{
					if (data.case == 'install') {
						load = '<div class="spinner-grow spinner-grow-sm text-light" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow spinner-grow-sm text-light" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow spinner-grow-sm text-light" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow spinner-grow-sm text-light" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow spinner-grow-sm text-light" role="status"><span class="sr-only">Loading...</span></div>';
						div = '<div class="bg-dark p-3"><pre class="text-white"><code>'+data.message+'<br>'+load+'</code></pre></div>';
	    				$('#formmodal').modal('show');
	    				$('#formmodal .modal-content .modal-body').html(div);
	    				setTimeout(function() {
	    					window.location.href = route('listmodules');
	    				}, 5000);
	    			} else {
	    				window.location.href = route('listmodules');
	    			}
				}
			});
			@endif
		});
	</script>
@endsection