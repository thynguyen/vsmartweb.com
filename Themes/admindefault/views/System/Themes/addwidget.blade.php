{!!Form::open(['method' => 'POST', 'route' => ['AddWidgetSite','id'=>$id], 'enctype'=> 'multipart/form-data'])!!}
@include('layouts.flash-message')
<div class="modal-header">
	<h4 class="modal-title">
		{{($widget['id'])?trans('Langcore::themes.EditWidget').' ['.$widget['title'].']':trans('Langcore::themes.AddWidget')}}
	</h4>
	<button class="close" type="button" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
</div>
<div class="modal-body">
	<div class="card card-body card-accent-primary">
		<div class="form-group row">
			{!!Form::label('title', trans('Langcore::global.Title'), ['class' => 'col-md-2 col-form-label']);!!}
			<div class="col-md-10">
				{!! Form::text('title', $widget['title'], ['class' => $errors->has('title') ? 'form-control is-invalid' : 'form-control','id'=>'title']) !!}
			</div>
		</div><div class="form-group row">
			{!!Form::label('description', trans('Langcore::global.Description'), ['class' => 'col-md-2 col-form-label']);!!}
			<div class="col-md-10">
				{!! Form::textarea('description', $widget['description'], ['class' => 'form-control','id'=>'description','rows'=>2]) !!}
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group row">
					{!!Form::label('custom_id', trans('Langcore::themes.CustomID'), ['class' => 'col-md-4 col-form-label']);!!}
					<div class="col-md-8">
						{!! Form::text('custom_id', $widget['custom_id'], ['class' => 'form-control','id'=>'custom_id']) !!}
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					{!!Form::label('custom_class', trans('Langcore::themes.CustomClass'), ['class' => 'col-md-4 col-form-label']);!!}
					<div class="col-md-8">
						{!! Form::text('custom_class', $widget['custom_class'], ['class' => 'form-control','id'=>'custom_class']) !!}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group row">
					{!!Form::label('coverwidget', trans('Langcore::themes.Templates'), ['class' => 'col-md-4 col-form-label']);!!}
					<div class="col-md-8">
						<select name="coverwidget" class="form-control">
							@foreach($coverwidget as $namecover => $cover)
							<option value="{{$cover['covername']}}" {{($cover['covername'] == $widget['coverwidget'])? 'selected="selected"': ''}}>{{$cover['covername']}}</option>
							@endforeach
						</select>
						@if ($errors->has('coverwidget'))
						<div class="invalid-feedback">
							{{ $errors->first('coverwidget') }}
						</div>
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					{!!Form::label('widgetgroup', trans('Langcore::themes.LocationDisplayed'), ['class' => 'col-md-4 col-form-label']);!!}
					<div class="col-md-8">
						<select name="widgetgroup" class="form-control text-uppercase">
							@foreach($widgetgroup as $namewggroup)
							<option value="{{$namewggroup}}" {{($placewidget == $namewggroup)? 'selected="selected"': ''}}>{{$namewggroup}}</option>
							@endforeach
						</select>
						@if ($errors->has('widgetgroup'))
						<div class="invalid-feedback">
							{{ $errors->first('widgetgroup') }}
						</div>
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					{!!Form::label('position', trans('Langcore::themes.WidgetType'), ['class' => 'col-md-4 col-form-label']);!!}
					<div class="col-md-8" id="showmodule">
						<select name="position" id="position" class="form-control" onchange="changeposition(this,'{{route('selectwidget')}}');">
							<option value="Core" {{($widget['originallocation'] == 'Core')? 'selected': ''}}>{{trans('Langcore::themes.SystemWidget')}}</option>
							@foreach($modules as $module => $mod)
							@if($mod['active'])
							<option value="{{$mod['path']}}" {{($mod['path'] == $modname)? 'selected': ''}}>{{$mod['name']}}</option>
							@endif
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					{!!Form::label('position', trans('Langcore::themes.WidgetName'), ['class' => 'col-md-4 col-form-label']);!!}
					<div class="col-md-8" id="showwidget">
						<select name="widgetname" class="{{$errors->has('widgetname') ? 'form-control is-invalid' : 'form-control'}}" onchange="loadconfigwidget(this,'{{route('showconfigwidget')}}'{{($id)?','.$id.'':''}});">
							<option value="">--</option>
							@foreach($widgetmod as $modwidgets => $modwidget)
							<option value="{{$modwidget['widgetname']}}" {{($modwidget['widgetname'] == $widgetfile)? 'selected': ''}}>{{$modwidget['widgetname']}}</option>
							@endforeach
						</select>
						@if ($errors->has('widgetname'))
						<div class="invalid-feedback">
							{{ $errors->first('widgetname') }}
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="configwidget">
		@if($widget['configwidget'] or $configwidget)
		{!!$configwidget!!}
		@endif
	</div>
</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-primary" type="submit">
		<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
	</button>
</div>
{!! Form::close() !!}
<script type="text/javascript">
	function changeposition(a,b){$('#showwidget').html('<div class="text-center form-control"><i class="fas fa-spinner fa-spin"></i>{{trans('Langcore::global.Loading')}}</div>');setTimeout(function(){$('#configwidget').empty();$.ajax({url: b+'/'+a.value, type: 'GET', contentType: "application/x-www-form-urlencoded;charset=utf-8", data:{_token: csrf_token}, success: function(result){$('#showwidget').html(result);}});}, 500);}function loadconfigwidget(a,b,c){$('#configwidget').html('<div class="card card-body card-accent-primary text-center"><i class="fas fa-spinner fa-spin fa-2x"></i>{{trans('Langcore::global.Loading')}}</div>');if (!a.value){var url=b+'/'+$('#position').val();}else{var url=b+'/'+$('#position').val()+'/'+a.value+'/'+c;}setTimeout(function(){$.ajax({url: url, type: 'GET', contentType: "application/x-www-form-urlencoded;charset=utf-8", data:{_token: "<?php echo csrf_token(); ?>"}, success: function(result){$('#configwidget').html(result);}});}, 500);}
</script>