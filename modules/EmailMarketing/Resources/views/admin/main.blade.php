@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('EmailMarketing','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_emailmarketing_main')}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<div class="mb-3">
{!!transmod('EmailMarketing::NumEmailContact',['num'=>$members['total_items']])!!}
</div>
<table class="table table-responsive-sm table-striped bg-white">
	<thead class="thead-dark">
		<tr>
			<th>{!!trans('Langcore::global.Email')!!}</th>
			<th>{!!trans('Langcore::global.Firstname')!!}</th>
			<th>{!!trans('Langcore::global.Lastname')!!}</th>
			<th>{!!trans('Langcore::global.Phone')!!}</th>
			<th>Email Marketing</th>
			<th>{!!trans('Langcore::global.CreatDate')!!}</th>
			<th>{!!trans('Langcore::global.UpdateDate')!!}</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($members['members'] as $member)
		<tr class="member{!!$member['web_id']!!}">
			<td>{!!$member['email_address']!!}</td>
			<td>{!!$member['merge_fields']['FNAME']!!}</td>
			<td>{!!$member['merge_fields']['LNAME']!!}</td>
			<td>{!!$member['merge_fields']['PHONE']!!}</td>
			<td>
				@if($member['status']=='subscribed')
				{!!transmod('EmailMarketing::Subscribed')!!}
				@elseif($member['status']=='unsubscribed')
				{!!transmod('EmailMarketing::Unsubscribed')!!}
				@endif
			</td>
			<td>{!!\Carbon\Carbon::parse($member['timestamp_opt'])!!}</td>
			<td>{!!\Carbon\Carbon::parse($member['last_changed'])!!}</td>
			<td>
				<button type="button" class="btn btn-sm {!!($member['status'] == 'subscribed')?'btn-warning':'btn-primary'!!}" onclick="subscribe(this,'{!!$member['email_address']!!}');">
					<i class="{!!($member['status'] == 'subscribed')?'fal':'fas'!!} fa-envelope"></i>
				</button>
				<button type="button" class="btn btn-sm btn-danger" onclick="deleteemail(this,'{!!$member['email_address']!!}');"><i class="fal fa-trash-alt"></i></button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection
@section('footer')
<script type="text/javascript" src="{!!asset('modules/js/emailmarketing/adminemailmarketing.js.php')!!}"></script>
<script type="text/javascript">
	var ConfirmAction = '{!!transmod('EmailMarketing::ConfirmAction')!!}';
</script>
@endsection