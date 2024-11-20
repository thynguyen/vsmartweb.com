<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>ID</th>
			<th>{{trans('Langcore::global.Account')}}</th>
			<th>Email</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($listmember as $member)
		<tr>
			<td>{{$member->id}}</td>
			<td>{{$member->username}}</td>
			<td>{{$member->email}}</td>
			<td>
				<button class="btn btn-sm btn-primary" type="button" onclick="addidmember('{{$member->username}}')"><i class="fas fa-plus-square"></i></button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
{!! $listmember->render() !!}