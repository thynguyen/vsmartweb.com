<div class="modal-body">
	{!!Form::open(['method' => 'POST', 'route' => ['licenses.admin.addversion'], 'enctype'=> 'multipart/form-data'])!!}
		<div class="form-group row">
			{!!Form::label('vswversion', trans('Langcore::licenses.Version'),['class' =>'col-sm-3 col-form-label']);!!}
			<div class="col-sm-9">
		        {!! Form::text('vswversion', old('vswversion'), ['class' => 'form-control form-control','id'=>'vswversion','required']) !!}
		    </div>
	    </div>
	    <button type="button" class="btn btn-block btn-primary mb-3" onclick="pluschangelog();"><i class="fal fa-plus"></i> {{trans('Langcore::licenses.AddChange')}}</button>
	    <div id="listchangelog">
	    </div>
	    <button type="submit" class="btn btn-sm btn-primary">{!!trans('Langcore::global.Save')!!}</button>
	{!! Form::close() !!}
</div>