@include('layouts.flash-message')
<div class="bg-white p-5 text-center border rounded shadow-sm">
{!!Form::open(['method' => 'POST', 'route' => ['uploadimg','namedata'=>$value], 'enctype'=> 'multipart/form-data', 'files' => true])!!}
	<div class="form-group mb-3">
		{!!Form::file($value, ['id'=>$value])!!}
		@if ($errors->has($value))
		<div class="invalid-feedback">
			{{ $errors->first($value) }}
		</div>
		@endif
	</div>
	<button class="btn btn-primary" type="submit">
		<i class="fas fa-upload"></i> {{trans('Langcore::global.Save')}}
	</button>
{!! Form::close() !!}
</div>