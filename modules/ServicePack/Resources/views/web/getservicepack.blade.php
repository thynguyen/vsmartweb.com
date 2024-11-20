<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>{{transmod('ServicePack::ServicePack')}}</th>
				<th>{{transmod('ServicePack::UnitPrice')}}</th>
				<th>{{transmod('ServicePack::IntoMoney')}}</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{$servicepack->title}}@if($paymentcycle) - <span class="showpaymentcycle">{{$paymentcycle}}</span>@endif</td>
				<td>
					@if($servicepack->code == 'c59186477' || $servicepack->code == 'b24ce0cd3')
					<strong class="d-block">FREE</strong>
					@else
					@if($servicepack->price_sale > 0)
					<strong class="d-block"><span class="getpriceservvice" data-price="{!!$servicepack->price_sale!!}">{!!FomartMoney($servicepack->price_sale,2)!!}</span> đ</strong>
					<del><small>{!!FomartMoney($servicepack->price,2)!!} đ</small></del>
					@else
					<strong class="d-block"><span class="getpriceservvice" data-price="{!!$servicepack->price!!}">{!!FomartMoney($servicepack->price,2)!!}<span> đ</strong>
					@endif
					@endif
				</td>
				<td><strong class="text-danger total-price">{{($servicepack->code == 'c59186477' || $servicepack->code == 'b24ce0cd3')?'FREE':FomartMoney($total,2).' đ'}}</strong></td>
			</tr>
		</tbody>
	</table>
</div>
<div class="webpackage-plans rounded-3 shadow p-4 mb-4 d-none d-lg-block">
    <div class="webpackage-plans-content">
        @if($servicepack->listoption!='null')
        <ul class="list-unstyled">
            @foreach(json_decode($servicepack->listoption,true) as $key => $option)
            <li class="check">
                <span>{{$option}}</span>
                <i class="fas fa-check"></i>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
</div>