@extends('layouts.master')
@section('breadcrumbs')
{{Breadcrumbs::render('module_servicepack_main')}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<div id="servicepack">
	<div class="row">
		@foreach($servicepacks as $price)
		<div class="col-sm-{{($servicepacks->count()<5)?round(12/$servicepacks->count()):'3'}}">
			<div class="webpackage-plans rounded-3 shadow p-4 mb-4{{($price->popular == 1)?' active':''}}">
	             <div class="webpackage-plans-header">
	                <h5>
	                   {{$price->title}}
	                   @if($price->description)
	                   <small>{{$price->description}}</small>
	                   @endif
	                </h5>
	                @if($price->contact == 1)
	                <div class="webpackage-plans-price">
	                   {{transmod('ServicePack::Contact')}}
	                </div>
					@else
					@if($price->price_sale > 0)
					<div class="webpackage-plans-price d-flex justify-content-between align-items-center">
						<div class="lh-1">
							<strong class="d-block">{!!FomartMoney($price->price_sale,2)!!} đ</strong>
							<del><small>{!!FomartMoney($price->price,2)!!} đ</small></del>
						</div>
						<small>/{{transmod('ServicePack::Month')}}</small>
	                </div>
					@else
	                <div class="webpackage-plans-price">
	                   <strong>{!!FomartMoney($price->price,2)!!} đ</strong>
	                   <small>/{{transmod('ServicePack::Month')}}</small>
	                </div>
					@endif
					@endif
	             </div>
	             <div class="webpackage-plans-content">
					@if($price->listoption!='null')
	                <ul class="list-unstyled">
	                	@foreach(json_decode($price->listoption,true) as $key => $option)
						<li class="check">
							<span>{{$option}}</span>
							<i class="fas fa-check"></i>
						</li>
						@endforeach
	                </ul>
	                @endif
	             </div>
	             <div class="webpackage-plans-footer text-center">
	             	<a href="@if($price->contact == 0){{route('servicepack.web.registerservice',['packcode'=>$price->code])}}@else{{route('contact.web.main')}}@endif" title="" class="btn btn-warning rounded-pill px-4 fw-bold">
						@if($price->contact == 0)
						@if(Auth::check()){{transmod('ServicePack::Upgrade')}}@else{{transmod('ServicePack::Trial')}}@endif
						@else
						{{transmod('ServicePack::Contact')}}
						@endif
		             </a>
	             </div>
	          </div>
		</div>
		@endforeach
	</div>
</div>
@endsection
@section('footer')
@endsection