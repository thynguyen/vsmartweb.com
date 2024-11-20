<div class="modal-body">
	<h4>{!!$campaign['subject_line']!!}</h4>
	<div class="row">
		<div class="col-sm-6">
			<dl class="row">
				<dt class="col-sm-4">{!!transmod('EmailMarketing::Recipients')!!}</dt>
				<dd class="col-sm-8">{!!$campaign['emails_sent']!!}</dd>
			</dl>
		</div>
		<div class="col-sm-6">
			<dl class="row">
				<dt class="col-sm-4">{!!transmod('EmailMarketing::DeliveryTime')!!}</dt>
				<dd class="col-sm-8">{!!\Carbon\Carbon::parse($campaign['send_time'])!!}</dd>
			</dl>
		</div>
	</div>
	<div class="row no-gutters mb-3">
		<div class="border border-right-0 rounded-left p-3 col-sm-3">
			<span class="h5">{!!$campaign['opens']['unique_opens']!!}</span>
			<span>{!!transmod('EmailMarketing::Opened')!!}</span>
		</div>
		<div class="border border-right-0 p-3 col-sm-3">
			<span class="h5">{!!$campaign['clicks']['unique_clicks']!!}</span>
			<span>{!!transmod('EmailMarketing::Clicked')!!}</span>
		</div>
		<div class="border p-3 col-sm-3">
			<span class="h5">{!!$campaign['bounces']['hard_bounces']!!}</span>
			<span>{!!transmod('EmailMarketing::Bounced')!!}</span>
		</div>
		<div class="border border-left-0 rounded-right p-3 col-sm-3">
			<span class="h5">{!!$campaign['unsubscribed']!!}</span>
			<span>{!!transmod('EmailMarketing::Unsubscribed')!!}</span>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-sm-6">
			<ul class="list-group list-group-flush">
				<li class="list-group-item d-flex justify-content-between">
					<span>{!!transmod('EmailMarketing::TotalOpens')!!}</span>
					<span>{!!$campaign['opens']['opens_total']!!}</span>
				</li>
				<li class="list-group-item d-flex justify-content-between">
					<span>{!!transmod('EmailMarketing::LastOpened')!!}</span>
					<span>{!!\Carbon\Carbon::parse($campaign['opens']['last_open'])!!}</span>
				</li>
			</ul>
		</div>
		<div class="col-sm-6">
			<ul class="list-group list-group-flush">
				<li class="list-group-item d-flex justify-content-between">
					<span>{!!transmod('EmailMarketing::TotalClicks')!!}</span>
					<span>{!!$campaign['clicks']['clicks_total']!!}</span>
				</li>
				<li class="list-group-item d-flex justify-content-between">
					<span>{!!transmod('EmailMarketing::LastOpened')!!}</span>
					<span>{!!\Carbon\Carbon::parse($campaign['clicks']['last_click'])!!}</span>
				</li>
			</ul>
		</div>
	</div>
	@if(count($campaign_open['members'])>0)
	<h4>{!!transmod('EmailMarketing::ListOpens')!!}</h4>
	<div class="card">
		<div class="card-body p-1">
			<ul class="list-group list-group-flush">
				@foreach($campaign_open['members'] as $open)
				<li class="list-group-item d-flex justify-content-between">
					<span>{!!$open['email_address']!!}</span>
					<span>{!!$open['opens_count']!!}</span>
				</li>
				@endforeach
			</ul>
		</div>
	</div>
	@endif
	@if(count($campaign_unsubscribed['unsubscribes'])>0)
	<h4>{!!transmod('EmailMarketing::Unsubscribed')!!}</h4>
	<div class="card">
		<div class="card-body p-1">
			<ul class="list-group list-group-flush">
				@foreach($campaign_unsubscribed['unsubscribes'] as $unsubscribes)
				<li class="list-group-item d-flex justify-content-between">
					<span>{!!$unsubscribes['email_address']!!}</span>
					<span>{!!\Carbon\Carbon::parse($unsubscribes['timestamp'])!!}</span>
				</li>
				@endforeach
			</ul>
		</div>
	</div>
	@endif
</div>