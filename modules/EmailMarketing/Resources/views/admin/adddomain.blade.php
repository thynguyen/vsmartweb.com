<div class="modal-body">
	{!!Form::open(['method' => 'POST', 'route' => ['emailmarketing.admin.adddomain'], 'enctype'=> 'multipart/form-data'])!!}
		<div class="form-group">
			{!! Html::decode(Form::label('email','Email', ['class' =>'col-form-label'])) !!}
		    {!! Form::text('email', old('email'), ['class' => 'form-control','id'=>'email','required']) !!}
		    <small id="emailHelp" class="form-text text-muted">
		    	{!!transmod('EmailMarketing::EmailWantVerify')!!}
		    </small>
		</div>
		<button type="submit" class="btn btn-sm btn-primary">
			{!!trans('Langcore::global.Save')!!}
		</button>
	{!! Form::close() !!}
</div>