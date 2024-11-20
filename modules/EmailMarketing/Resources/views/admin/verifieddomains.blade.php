@extends('layouts.master')
@section('metatitle',transmod('EmailMarketing::VerifiedDomains'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_emailmarketing_verifieddomains')}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<div class="mb-3">
	<button type="button" class="btn btn-sm btn-primary" onclick="adddomain();">
		{!!transmod('EmailMarketing::VerifyEmailDomain')!!}
	</button>
</div>
<ul class="list-group list-group-flush">
	@foreach($verifieddomains['domains'] as $domain)
	<li class="list-group-item">
		<div class="row">
			<div class="col-sm-8">
				<strong><i class="fas fa-globe"></i> {!!$domain['domain']!!}</strong>
			</div>
			<div class="col-sm-2">
				@if($domain['verified'] == true)
				{!!transmod('EmailMarketing::Verified')!!}
				@else
				{!!transmod('EmailMarketing::Pending')!!}
				@endif
			</div>
			<div class="col-sm-2">
				@if($domain['verified'] == false)
				<button type="button" class="btn btn-sm btn-warning" onclick="entercode('{!!$domain['domain']!!}')">
					{!!transmod('EmailMarketing::EnterCode')!!}
				</button>
				@endif
				<button type="button" class="btn btn-sm btn-danger" onclick="deletedomain(this,'{!!$domain['domain']!!}');">
					<i class="fal fa-trash-alt"></i>
				</button>
			</div>
		</div>
	</li>
	@endforeach
</ul>
@endsection
@section('footer')
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<script type="text/javascript" src="{!!asset('modules/js/emailmarketing/adminemailmarketing.js.php')!!}"></script>
<script type="text/javascript">
	var ConfirmAction = '{!!transmod('EmailMarketing::ConfirmAction')!!}';
</script>
@endsection