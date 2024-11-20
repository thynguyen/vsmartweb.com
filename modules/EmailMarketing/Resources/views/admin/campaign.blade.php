@extends('layouts.master')
@section('metatitle',transmod('EmailMarketing::Campaign'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_emailmarketing_campaign')}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<div class="mb-3">
	<button type="button" class="btn btn-sm btn-primary" onclick="redirectroute('{!!route('emailmarketing.admin.addcampaign')!!}')">
		{!!transmod('EmailMarketing::AddCampaign')!!}
	</button>
</div>
<table class="table table-responsive-sm table-striped bg-white">
	<thead class="thead-dark">
		<tr>
			<th>{!!transmod('EmailMarketing::Campaign')!!}</th>
			<th>{!!trans('Langcore::global.Status')!!}</th>
			<th>{!!transmod('EmailMarketing::Opened')!!}</th>
			<th>{!!transmod('EmailMarketing::Clicked')!!}</th>
			<th width="160"></th>
		</tr>
	</thead>
	<tbody>
		@foreach($campaigns as $campaign)
		<tr class="campaign{!!$campaign['id']!!}">
			<td>
				<strong>{!!(!empty($campaign['settings']['subject_line']))?$campaign['settings']['subject_line']:$campaign['settings']['title']!!}</strong><br>
				<small>
				{!!transmod('EmailMarketing::Sent')!!} {!!$campaign['emails_sent']!!}/{!!$campaign['recipients']['recipient_count']!!} {!!transmod('EmailMarketing::Subscribed')!!} | {!!transmod('EmailMarketing::DeliveryTime')!!}: {!!\Carbon\Carbon::parse($campaign['send_time'])!!}
				</small>
			</td>
			<td>
				@if($campaign['status']=='save')
				<span class="badge badge-light">{!!transmod('EmailMarketing::Draft')!!}</span>
				@elseif($campaign['status']=='sent')
				<span class="badge badge-success">{!!transmod('EmailMarketing::Sent')!!}</span>
				@endif
			</td>
			<td>
				@if($campaign['status']=='sent')
				<span>{!!$campaign['report_summary']['unique_opens']!!}</span>/
				<span>{!!round($campaign['report_summary']['open_rate'],2)!!}%</span>
				@endif
			</td>
			<td>
				@if($campaign['status']=='sent')
				<span>{!!$campaign['report_summary']['clicks']!!}</span>/
				<span>{!!round($campaign['report_summary']['click_rate'],2)!!}%</span>
				@endif
			</td>
			<td>
				@if($campaign['status']=='save')
				<button type="button" class="btn btn-sm btn-primary" onclick="editcampaign('{!!$campaign['id']!!}');"><i class="fal fa-pen"></i></button>
				<button type="button" class="btn btn-sm btn-success" onclick="sentcampaign(this,'{!!$campaign['id']!!}');"><i class="fal fa-paper-plane"></i></button>
				@elseif($campaign['status']=='sent')
				<button type="button" class="btn btn-sm btn-primary" onclick="viewreport('{!!$campaign['id']!!}')"><i class="fal fa-chart-bar"></i></button>
				@endif
				<button type="button" class="btn btn-sm btn-danger" onclick="delcampaign(this,'{!!$campaign['id']!!}')"><i class="fal fa-trash-alt"></i></button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection
@section('footer')
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<script type="text/javascript" src="{!!asset('modules/js/emailmarketing/adminemailmarketing.js.php')!!}"></script>
<script type="text/javascript">
	var ConfirmAction = '{!!transmod('EmailMarketing::ConfirmAction')!!}';
</script>
@endsection