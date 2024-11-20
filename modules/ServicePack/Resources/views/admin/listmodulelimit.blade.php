@foreach($roles as $role)
<div class="form-group row">
	{!!Form::label('listroles-'.$role->modules, $role->modules,['class' =>'col-sm-6 col-form-label']);!!}
	<div class="col-sm-6">
		{!! Form::number('listroles['.$role->modules.']', null, ['class' => 'form-control','id'=>'listroles-'.$role->modules]) !!}
    </div>
</div>
@endforeach