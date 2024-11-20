<div class="modal-body">
	{!!Form::open(['method' => 'POST', 'route' => ['contact.web.submitcontact'], 'enctype'=> 'multipart/form-data'])!!}
		<div class="form-group">
			{!! Form::text('fullname', null, ['class' => 'form-control','id'=>'fullname','placeholder'=>trans('Langcore::global.FullName'),'required']) !!}
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
				{!! Form::text('mobile', null, ['class' => 'form-control','id'=>'mobile','placeholder'=>trans('Langcore::global.Phone'),'required']) !!}
			</div>
			<div class="form-group col-md-6">
				{!! Form::text('email', null, ['class' => 'form-control','id'=>'email','placeholder'=>trans('Langcore::global.Email'),'required']) !!}
			</div>
		</div>
		@if($parts)
		<div class="form-group">
			{!!Form::select('partid', [''=>transmod('Contact::Parts')]+$parts, null, ['class' => 'form-control', 'id'=>'partid', 'tabindex' => '2', 'required'])!!}
		</div>
		@endif
		<div class="form-group">
			{!! Form::text('title', null, ['class' => 'form-control','id'=>'title','placeholder'=>trans('Langcore::global.Title'),'required']) !!}
		</div>
		<div class="form-group">
			{!! Form::textarea('messenger', null, ['class' => 'form-control','id'=>'messenger','rows'=>5,'placeholder'=>trans('Langcore::global.Content'),'required']) !!}
		</div>
		<div class="form-group">
			@CapchaSite()
			@if ($errors->has('g-recaptcha-response'))
            <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
            @endif
		</div>
		<button class="btn btn-sm btn-primary" type="submit">
			<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
		</button>
	{!! Form::close() !!}
</div>