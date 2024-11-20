<div>
	<div class="d-flex justify-content-between mb-3">
		<div class="button">
			<button type="button" class="btn btn-sm btn-primary" onclick="redirectroute('{!!route('members.admin.register')!!}')"><i class="fal fa-user-plus mr-1"></i>{!!transmod('members::AddMember')!!}</button>
		</div>
		<div class="search rounded">
            {!! Form::text('searchmem', null, ['id'=>'searchmem','placeholder'=>trans('Langcore::global.Search'),'wire:model'=>'searchmem']) !!}
            <i class="fas fa-search"></i>
		</div>
	</div>
	<table class="table table-responsive-sm table-striped bg-white">
		<thead class="thead-dark">
			<tr>
				<th>ID</th>
				<th>Avatar</th>
				<th>User</th>
				<th>{!!trans('Langcore::global.FullName')!!}</th>
				<th>Email</th>
				<th>{!!trans('Langcore::global.CreatDate')!!}</th>
				<th>{!!trans('Langcore::global.Active')!!}</th>
				<th>{!!trans('Langcore::global.Action')!!}</th>
			</tr>
		</thead>
		<tbody>
			@if($members)
			    @foreach($members as $member)
			    <tr id="member{!!$member->id!!}">
			    	<td>{!!$member->id!!}</td>
			    	<td><img alt="{!!$member->username!!}" src="{!!$member->avatar_link!!}" width="35px" /></td>
			    	<td>{!!$member->username!!}</td>
			    	<td>{!!$member->full_name!!}</td>
			    	<td>{!!$member->email!!}</td>
			    	<td>{!!CFglobal::formattime(strtotime($member->created_at),'format','d/m/Y')!!}</td>
			    	<td>
			    		<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input" id="active{!!$member->id!!}" onchange="activemem('{!!$member->id!!}');" {{($member->active)? 'checked':''}}>
								<label class="custom-control-label" for="active{!!$member->id!!}"></label>
						</div>
			    	</td>
			    	<td>
						<div class="btn-group">
							<button class="btn btn-sm btn-primary" type="button" onclick="redirectroute('{{ route('members.admin.edituser',['id'=>$member->id]) }}')"><i class="fas fa-edit"></i></button>
							<button class="btn btn-sm btn-danger active"type="button" onclick="delmem('{!!$member->id!!}')" {!!($member->in_group == 0)?'':'disabled'!!}><i class="fas fa-trash-alt"></i></button>
						</div>
			    	</td>
			    </tr>
			    @endforeach
			@else
			<tr>
				<td colspan="8" class="text-center">
					{!!trans('Langcore::global.EmptyRow')!!}
				</td>
			</tr>
			@endif
		</tbody>
	</table>
	{!!$paginator!!}
</div>