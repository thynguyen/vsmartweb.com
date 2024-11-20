<div id="listadmin">
	<table class="table table-responsive-sm table-striped table-sm">
		<thead>
			<tr>
				<th>ID</th>
				<th>{{trans('Langcore::permissions.Level')}}</th>
				<th>{{trans('Langcore::global.Account')}}</th>
				<th>Email</th>
				<th>{{trans('Langcore::permissions.Roles')}}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($listadmin as $admin)
			<tr>
				<td>
					{{$admin['userid']}}
				</td>
				<td>
					{!!$admin['lever']!!}
				</td>
				<td>{{$admin['username']}}</td>
				<td>{{$admin['email']}}</td>
				<td>{{$admin['name']}}</td>
				<td>
					@if($admin['userid'] > 1)
					<div class="btn-group">
						<button class="btn btn-sm btn-primary" type="button" onclick="redirectroute('{{ route('addadmin',['id'=>$admin['userid']]) }}')"><i class="fas fa-edit"></i></button>
						<button class="btn btn-sm btn-danger active"type="button" onclick="delpermission('{{ ($admin['userid']==1 or $admin['in_group']==1)?'':route('deladmin',['id'=>$admin['userid']]) }}','#listadmin','{{trans('Langcore::global.warning_delfile')}}')" {{($admin['userid']==1 or $admin['in_group']==1)?'disabled':''}}><i class="fas fa-trash-alt"></i></button>
					</div>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>	
{!! $listadmin->render() !!}
</div>