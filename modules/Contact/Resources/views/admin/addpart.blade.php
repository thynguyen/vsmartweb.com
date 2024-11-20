{!!Form::open(['method' => 'POST', 'route' => ['contact.admin.addpart',$part['id']], 'enctype'=> 'multipart/form-data'])!!}
<div class="modal-body">
	{!! Form::hidden('partid', $part['id'], ['class'=>'partid']) !!}
	<div class="form-group">
	    {!! Form::text('title', $part['title'], ['class' => 'form-control','id'=>'title','placeholder'=>trans('Langcore::global.Title')]) !!}
	</div>
	<div class="form-group">
	    {!! Form::text('mobile', $part['mobile'], ['class' => 'form-control','id'=>'mobile','placeholder'=>trans('Langcore::global.Phone')]) !!}
	</div>
	<div class="form-group">
	    {!! Form::text('email', $part['email'], ['class' => 'form-control','id'=>'email','placeholder'=>trans('Langcore::global.Email')]) !!}
	</div>
	<div class="card">
		<div class="card-body">
			<table class="table table-responsive-sm table-striped">
				<thead class="thead-dark">
					<tr>
						<th>{!!trans('Langcore::global.FullName')!!}</th>
						<th>{!!trans('Langcore::global.Email')!!}</th>
						<th class="text-center">{!!transmod('contact::ReceiveEmail')!!}</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="listrecipients">
					@if($part)
					@foreach($part->partsemail as $partsemail)
					<tr class="user{!!$partsemail->user->id!!}">
						<td>
							{!! Form::hidden('recipients['.$partsemail->user->id.'][userid]', $partsemail->user->id, ['class'=>'userid']) !!}
							{!!$partsemail->user->lastname!!} {!!$partsemail->user->firstname!!}
						</td>
						<td>{!!$partsemail->user->email!!}</td>
						<td class="text-center">
							{!!Form::checkbox('recipients['.$partsemail->user->id.'][sendemail]',1,($partsemail->sendemail==0)?false:true)!!}
						</td>
						<td><button type="button" class="btn btn-sm btn-danger" onclick="delrecipient({!!$partsemail->user->id!!})"><i class="fal fa-trash-alt"></i></button></td>
					</tr>
					@endforeach
					@endif
				</tbody>
			</table>
			<button type="button" class="btn btn-sn btn-block btn-primary" onclick="addrecipients();">{!!transmod('contact::AddEmailRecipients')!!}</button>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button class="btn btn-sm btn-primary" type="submit">
		<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
	</button>
</div>
{!! Form::close() !!}