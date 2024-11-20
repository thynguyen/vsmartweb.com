<div class="modal-body">
	{!!Form::open(['method' => 'POST', 'route' => ['licenses.admin.licenseregister','id'=>$license['id']], 'enctype'=> 'multipart/form-data'])!!}
		<div class="form-group">
			{!!Form::label('license', trans('Langcore::licenses.License'),['class' =>'col-form-label']);!!}
			<div class="d-flex">
		        {!! Form::text('license', $license['license'], ['class' =>'form-control form-control-sm w-100','id'=>'license','placeholder'=>'','readonly']) !!}
		        @if(!$license)
		        <button type="button" class="btn btn-sm btn-primary ml-2" onclick="getcodelincense();"><i class="fal fa-sync-alt"></i></button>
		        @endif
		    </div>
	    </div>
		<div class="form-group">
			{!!Form::label('domain', trans('Langcore::licenses.Domain'),['class' =>'col-form-label']);!!}
	        {!! Form::text('domain', $license['domain'], ['class' => $errors->has('domain') ? 'form-control form-control-sm is-invalid' : 'form-control form-control-sm','id'=>'domain','placeholder'=>'','required']) !!}
	        @if ($errors->has('domain'))
	        <div class="invalid-feedback">{{ $errors->first('domain') }}</div>
	        @endif
	    </div>
	    <div class="row">
	    	<div class="col-sm-6">
				<div class="form-group">
					{!!Form::label('start_day', trans('Langcore::licenses.StartDay'),['class' =>'col-form-label']);!!}
			        {!! Form::text('start_day', $license['start_day'], ['class' => 'form-control form-control-sm formdate','id'=>'start_day','autocomplete'=>'off','required']) !!}
			    </div>
	    	</div>
	    	<div class="col-sm-6">
				<div class="form-group">
					{!!Form::label('expiration_date', trans('Langcore::licenses.ExpirationDate'),['class' =>'col-form-label']);!!}
			        {!! Form::text('expiration_date', $license['expiration_date'], ['class' => 'form-control form-control-sm formdate','id'=>'expiration_date','autocomplete'=>'off']) !!}
			    </div>
	    	</div>
	    </div>
		<div class="form-group">
			{!!Form::label('status', trans('Langcore::licenses.Status'),['class' =>'col-form-label']);!!}
	        {!!Form::select('status', $status, $license['status'], ['class' => 'form-control','id'=>'status'])!!}
	    </div>
		<div class="form-group">
			{!!Form::label('message', trans('Langcore::licenses.Note'),['class' =>'col-form-label']);!!}
	        {!! Form::textarea('message', $license['message'], ['class' => 'form-control form-control-sm','id'=>'message','placeholder'=>'','rows'=>4]) !!}
	    </div>
	    <button type="submit" class="btn btn-sm btn-primary">{!!trans('Langcore::global.Save')!!}</button>
	{!! Form::close() !!}
</div>