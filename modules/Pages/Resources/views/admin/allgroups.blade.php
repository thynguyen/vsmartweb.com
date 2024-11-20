<div>
	<div class="d-flex justify-content-between mb-3">
		<div class="button">
			<button type="button" class="btn btn-primary btn-sm" onclick="addgroup();">{!!transmod('Pages::AddGroup')!!}</button>
		</div>
		<div class="search rounded">
            {!! Form::text('searchgroup', null, ['id'=>'searchgroup','placeholder'=>trans('Langcore::global.Search'),'wire:model'=>'searchgroup']) !!}
            <i class="fas fa-search"></i>
		</div>
	</div>
	<table class="table table-responsive-sm table-striped bg-white">
		<thead class="thead-dark">
			<tr>
				<th>{!!trans('Langcore::global.Title')!!}</th>
				<th width="120">{!!trans('Langcore::global.Action')!!}</th>
			</tr>
		</thead>
		<tbody>
			@if($groups)
			    @foreach($groups as $group)
			    <tr id="group{!!$group->id!!}">
			    	<td>{!!$group->title!!}</td>
			    	<td>
						<div class="btn-group">
							<button class="btn btn-sm btn-primary" type="button" onclick="addgroup('{!!$group->id!!}')"><i class="fas fa-pencil-alt"></i></button>
							<button class="btn btn-sm btn-danger active"type="button" onclick="delgroup('{!!$group->id!!}')"><i class="fas fa-trash-alt"></i></button>
						</div>
			    	</td>
			    </tr>
			    @endforeach
			@endif
		</tbody>
	</table>
	{!!$paginator!!}
</div>