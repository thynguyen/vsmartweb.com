{!!Form::open(['method' => 'POST', 'route' => ['sliders.admin.addgroup',$group['id']], 'enctype'=> 'multipart/form-data'])!!}
<div class="modal-body">
	<div class="form-group">
	    {!! Form::text('title', $group['title'], ['class' => 'form-control form-control-sm','id'=>'title','placeholder'=>trans('Langcore::global.Title')]) !!}
	</div>
</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-primary" type="submit">
		<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
	</button>
</div>
{!! Form::close() !!}