<div class="modal-body">
	{!!Form::open(['method' => 'POST', 'route' => ['emailmarketing.admin.editcampaign','id'=>$id], 'enctype'=> 'multipart/form-data'])!!}
	<div class="form-group">
		{!!CKediter::ckediter('contents',$campaign)!!}
		{!!CKediter::ckediterjs('contents',300)!!}
	</div>
	<button class="btn btn-sm btn-primary" type="submit">
		<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
	</button>
	{!! Form::close() !!}
</div>