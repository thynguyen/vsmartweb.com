{!!Form::open(['method' => 'POST', 'route' => ['menus.admin.addgroup',$group['id']], 'enctype'=> 'multipart/form-data'])!!}
<div class="modal-body">
	<div class="form-group">
	    {!! Form::text('title', $group['title'], ['class' => 'form-control form-control-sm','id'=>'title','placeholder'=>trans('Langcore::global.Title')]) !!}
	</div>
	<div class="form-group">
	    {!! Form::textarea('description', $group['description'], ['class' => 'form-control form-control-sm','id'=>'description','rows'=>3,'placeholder'=>trans('Langcore::global.Description')]) !!}
	</div>
</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-primary" type="submit">
		<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
	</button>
</div>
{!! Form::close() !!}