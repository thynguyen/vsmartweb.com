<div>
	<div class="card">
		<div class="card-body p-2">
			<div class="d-flex align-items-center justify-content-between">
				<div class="button">
					<button type="button" class="btn btn-sm btn-primary" onclick="redirectroute('{!!route('news.admin.addnew')!!}');">
						{!!transmod('News::AddNew')!!}
					</button>
				</div>
				<div class="search rounded">
		            {!! Form::text('searchnews', null, ['id'=>'searchnews','placeholder'=>trans('Langcore::global.Search'),'wire:model'=>'searchnews']) !!}
		            <i class="fas fa-search"></i>
				</div>
			</div>
		</div>
	</div>
	<table class="table table-responsive-sm table-striped bg-white">
		<thead class="thead-dark">
			<tr>
				<th>ID</th>
				<th>{!!trans('Langcore::global.Title')!!}</th>
				<th>{!!transmod('News::BelongsToCatalog')!!}</th>
				<th>{!!trans('Langcore::global.CreatDate')!!}</th>
				<th>{!!trans('Langcore::global.Active')!!}</th>
				<th>{!!trans('Langcore::global.Action')!!}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($news as $key => $new)
			<tr id="new{!!$new->id!!}">
				<td>{!!$key + 1!!}</td>
				<td>{!!$new->title!!}</td>
				<td>
					@foreach($new->catpost as $cat)
					<span class="badge badge-success">{!!$cat->cat->title!!}</span>
					@endforeach
				</td>
				<td>
					{!!$new->created_at!!}
				</td>
				<td>
					<label class="switch switch-pill switch-outline-primary-alt switch-sm align-middle mb-0"><input class="switch-input" type="checkbox" onchange="activenew('{!!$new->id!!}')" {!!($new->active==1)?'checked=""':''!!}><span class="switch-slider"></span></label>
				</td>
				<td>
					<button type="button" class="btn btn-sm btn-primary" onclick="redirectroute('{!!route('news.admin.addnew',['id'=>$new->id])!!}');"><i class="fas fa-pencil-alt"></i></button>
					<button type="button" class="btn btn-sm btn-danger" onclick="deletenew('{!!$new->id!!}');"><i class="fas fa-trash-alt"></i></button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{!!$paginator!!}
</div>