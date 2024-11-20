@extends('layouts.master')
@section('metatitle',$trans->trading_code)
@section('breadcrumbs')
{{Breadcrumbs::render('admin_servicepack_viewtrans',$trans)}}
@endsection
@section('header')
@livewireStyles
@endsection
@section('content')
@include('layouts.flash-message')
@php
	$numyear = $trans->timeout/12;
    $paymentcycle =($numyear >= 1)?$numyear.' '.transmod('ServicePack::Year'):$trans->timeout.' '.transmod('ServicePack::Month');
@endphp
@if($trans->status == 0)
{!!Form::open(['method' => 'POST', 'route' => ['servicepack.admin.viewtrans','id'=>$trans->id], 'enctype'=> 'multipart/form-data','class'=>'needs-validation','novalidate'])!!}
@endif
<div class="card">
	<div class="card-body">
		<h5>{{transmod('ServicePack::OrderInfo',['servicepack'=>$trans->svpack->title,'expiredat'=>$paymentcycle]).' - '.trans('Langcore::global.Account').' '.$trans->user->username}}</h5>
		<hr>
		<dl class="row">
            <dt class="col-sm-4">{!!transmod('ServicePack::IntoMoney')!!}</dt>
            <dd class="col-sm-8"><span class="text-danger">{{FomartMoney($trans->price,2)}} VNĐ</span></dd>
            <dt class="col-sm-4">{!!transmod('ServicePack::TradingCode')!!}</dt>
            <dd class="col-sm-8">{{$trans->trans_code}}</dd>
            <dt class="col-sm-4">Pay Code</dt>
            <dd class="col-sm-8">{{$trans->transpay_code}}</dd>
            <dt class="col-sm-4">{!!trans('Langcore::global.Status')!!}</dt>
            <dd class="col-sm-8">
                @if($trans->status == 0)
            	{!!Form::select('status', $status, $trans->status, ['class' => 'form-control','id'=>'status'])!!}
                @elseif($trans->status == 1 )
                    <strong class="text-success">{{transmod('ServicePack::SuccessfulTransaction')}}</strong>
                @elseif($trans->status == 2 )
                    <strong class="text-dark">{{transmod('ServicePack::PaymentCanceled')}}</strong>
                @endif
            </dd>
            <dt class="col-sm-4">{!!transmod('ServicePack::UsedTime')!!}</dt>
            <dd class="col-sm-8">{{$trans->expired_at}}</dd>
        </dl>
		<div class="form-group">
			{!!Form::label('note', trans('Langcore::licenses.Note'),['class' =>'col-form-label']);!!}
            @if($trans->status == 0)
            {!!CKediter::ckediter('note',($trans->note)?$trans->note:'')!!}
            @else
            <div class="card"><div class="card-body">{{$trans->note}}</div></div>
            @endif
		</div>
	</div>
</div>
@if($trans->status == 0)
<div class="d-grid gap-2 col-4 mx-auto">
    <button type="submit" class="btn btn-lg btn-block btn-warning rounded-pill">
        {!!trans('Langcore::global.Save')!!}
    </button>
</div>
{!! Form::close() !!}
@endif
<div class="table-responsive mt-5">
    <table class="table table-hover bg-white">
        <thead class="thead-dark">
            <tr>
                <th>{{trans('Langcore::global.Status')}}</th>
                <th>{{trans('Langcore::licenses.Note')}}</th>
                <th>{{trans('Langcore::global.CreatDate')}}</th>
                <th>{{transmod('ServicePack::HandlingStaff')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trans->log as $log)
            <tr>
                <td>
                    @if($log->status == 2 )
                    {{transmod('ServicePack::PaymentCanceled')}}
                    @elseif($log->status == 1 )
                    <strong class="text-success">{{transmod('ServicePack::SuccessfulTransaction')}}</strong>
                    @else
                    <strong class="text-danger">{{transmod('ServicePack::PendingPayments')}}</strong>
                    @endif
                </td>
                <td>{{$log->note}}</td>
                <td>{{date_from_database($log->created_at,'H:i d/m/Y')}}</td>
                <td>
                    <strong>
                    @if(is_numeric($log->handler))
                    {{($log->handl)?$log->handl->username:''}}
                    @else
                    {{$log->handler}}
                    @endif
                    </strong>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('footer')
<script src="{{ asset('modules/js/servicepack/adminservicepack.js.php') }}"></script>
@livewireScripts
{!!CKediter::ckediterjs('note',100)!!}
@endsection