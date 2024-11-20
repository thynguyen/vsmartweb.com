@extends('layouts.master')
@section('breadcrumbs')
{{Breadcrumbs::render('module_servicepack_applyplan')}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<div class="row justify-content-md-center">
	<div class="col-lg-7">
		<div class="card mb-3" id="checkpay">
			<div class="card-body">
				<h5>{{$response->vnp_OrderInfo}}</h5>
				<hr>
				<dl class="row">
	                <dt class="col-sm-4">{!!transmod('ServicePack::IntoMoney')!!}</dt>
	                <dd class="col-sm-8"><span class="text-danger">{{FomartMoney($response->vnp_Amount/100,2)}} VNĐ</span></dd>
	                <dt class="col-sm-4">{!!transmod('ServicePack::TradingCode')!!}</dt>
	                <dd class="col-sm-8">{{$response->vnp_TransactionNo}}</dd>
	                <dt class="col-sm-4">{!!trans('Langcore::global.Status')!!}</dt>
	                <dd class="col-sm-8">{!!transmod('ServicePack::SuccessfulTransaction')!!}</dd>
	                <dt class="col-sm-4">{!!transmod('ServicePack::UsedTime')!!}</dt>
	                <dd class="col-sm-8">{{$expired}}</dd>
	            </dl>
			</div>
		</div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <a href="{{route('members.web.userpanel')}}" title="" class="btn btn-lg btn-warning rounded-pill">
                {!!transmod('ServicePack::GetStarted')!!}
            </a>
            <button type="button" class="btn btn-lg btn-warning rounded-pill" onclick="printDiv('#checkpay')">Print</button>
        </div>
	</div>
</div>
@endsection
@section('footer')
<script type="text/javascript" src="{{asset('js/vendor/printThis.js')}}"></script>
<script type="text/javascript">
	function printDiv(div) {
		$(div).printThis();
	}
</script>
@endsection