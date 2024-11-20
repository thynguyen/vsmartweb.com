<div class="modal-header">
	{!!transmod('EmailMarketing::VerifyEmailDomain')!!}
</div>
<div class="modal-body">
	<div class="mb-3">
		{!!transmod('EmailMarketing::NoteVerifyEmail',['email'=>$domain['verification_email'],'domain'=>$domain['domain'],'date'=>\Carbon\Carbon::parse($domain['verification_sent'])->translatedFormat('d/m/Y H:i A')])!!}
	</div>
	<div class="form-group">
		{!! Html::decode(Form::label('code',transmod('EmailMarketing::EnterVerificationCode'), ['class' =>'col-form-label'])) !!}
	    {!! Form::text('code', old('code'), ['class' => 'form-control','id'=>'code','required']) !!}
	    <small class="notify"></small>
	</div>
	<button type="button" class="btn btn-sm btn-primary" onclick="submitcode('{!!$domain['domain']!!}')">
		{!!transmod('EmailMarketing::Verify')!!}
	</button>
</div>