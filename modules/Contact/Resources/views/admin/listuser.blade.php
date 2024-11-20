@if(count($alluser)>0)
<div class="modal-body">
	<table class="table table-responsive-sm table-striped mb-0 bg-white">
		<thead class="thead-dark">
			<tr>
				<th></th>
				<th>{!!trans('Langcore::global.Account')!!}</th>
				<th>{!!trans('Langcore::global.Email')!!}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($alluser as $user)
			<tr>
				<td>
					<div class="form-check">
						{!!Form::checkbox('usercheck',$user->id,false,['class'=>'form-check-input','id'=>'usercheck'.$user->id])!!}
					</div>
				</td>
				<td class="nameuser{!!$user->id!!}">{!!$user->full_name!!}</td>
				<td class="emailuser{!!$user->id!!}">{!!$user->email!!}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-primary" type="button" onclick="getlistrecipients();">
		{!!transmod('contact::AddEmailRecipients')!!}
	</button>
</div>
@else
<div class="modal-body text-center">
	{!!transmod('contact::ListEmpty')!!}
</div>
@endif