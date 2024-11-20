<div>
	<div class="card">
		<div class="card-body p-2">
			<div class="d-flex align-items-center justify-content-between">
				<div class="select-status">
					{!!Form::select('status', $status, old('status'), ['class' => 'form-control','id'=>'status','wire:model'=>'selectstatus'])!!}
				</div>
				<div class="search rounded">
		            {!! Form::text('searchsvctrans', null, ['id'=>'searchsvctrans','placeholder'=>trans('Langcore::global.Search'),'wire:model'=>'searchsvctrans']) !!}
		            <i class="fas fa-search"></i>
				</div>
			</div>
		</div>
	</div>
	<table class="table table-responsive-sm table-striped bg-white">
		<thead class="thead-dark">
			<tr>
				<th>{{transmod('ServicePack::TradingCode')}}</th>
				<th>Pay Code</th>
				<th>{{trans('Langcore::global.Account')}}</th>
				<th>{{transmod('ServicePack::UsedTime')}}</th>
				<th>{{transmod('ServicePack::ServicePack')}}</th>
				<th>{{transmod('ServicePack::IntoMoney')}}</th>
				<th>{{trans('Langcore::global.Status')}}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@if($servicetrans->total()>0)
			@foreach($servicetrans as $trans)
			<tr>
				<td>
					@if($trans->readtrans == 0)
					<strong>{{$trans->trans_code}}</strong>
					@else
					{{$trans->trans_code}}
					@endif
				</td>
				<td>
					@if($trans->readtrans == 0)
					<strong>{{$trans->transpay_code}}</strong>
					@else
					{{$trans->transpay_code}}
					@endif
				</td>
				<td>
					{{$trans->user->username}}<button type="button" class="btn btn-sm btn-link" onclick="infouser('{{$trans->userid}}')"><i class="fal fa-bring-forward fa-lg"></i></button><br>
					<a href="https://who.is/whois-ip/ip-address/{{$trans->trans_ip}}" title="{{$trans->trans_ip}}" target="_black"><small>({{$trans->trans_ip}})</small></a>
				</td>
				<td>
					@if($trans->timeout != 0)
					@php
					$numyear = $trans->timeout/12;
        			$paymentcycle = ($numyear >= 1)?$numyear.' '.transmod('ServicePack::Year'):$trans->timeout.' '.transmod('ServicePack::Month');
					@endphp
					{{date_from_database($trans->expired_at,'Y/m/d')}} <small>({{$paymentcycle}})</small>
					@endif
				</td>
				<td>{{$trans->svpack->title}}</td>
				<td>{{FomartMoney($trans->price,2)}} VNĐ</td>
				<td>
					@if($trans->status == 1)
					<strong class="text-success">{{transmod('ServicePack::SuccessfulTransaction')}}</strong>
					@elseif($trans->status == 2)
					<strong class="text-dark">{{transmod('ServicePack::PaymentCanceled')}}</strong>
					@else
					<strong class="text-danger">{{transmod('ServicePack::PendingPayments')}}</strong>
					@endif
				</td>
				<td>
					<a href="{{route('servicepack.admin.viewtrans',['id'=>$trans->id])}}" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
				</td>
			</tr>
			@endforeach
			@else
			<tr>
				<td colspan="8" class="text-center">{{trans('Langcore::global.EmptyRow')}}</td>
			</tr>
			@endif
		</tbody>
	</table>
	{!!$paginator!!}
</div>