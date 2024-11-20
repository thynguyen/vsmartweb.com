@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('Contact','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_contact_main')}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<div class="row my-3">
    <div class="col-sm-5">
        {!!trans('Langcore::global.ShowTotalPage',['firstitem'=>$contacts->firstItem(),'lastitem'=>$contacts->lastItem(),'totalitem'=>$contacts->total()])!!}
    </div>
    <div class="col-sm-7">
        {!! $paginator !!}
    </div>
</div>
<table class="table table-responsive-sm table-striped bg-white">
	<thead class="thead-dark">
		<tr>
			<th></th>
			<th>{!!trans('Langcore::global.Title')!!}</th>
			<th>{!!transmod('contact::Sender')!!}</th>
			<th>{!!transmod('contact::SentDepartment')!!}</th>
			<th>{!!transmod('contact::SentAt')!!}</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($contacts as $contact)
		<tr id="contact{!!$contact->id!!}">
			<td>
				@if($contact->read==0)
				<i class="fas fa-envelope"></i>
				@elseif(count($contact->reply)>0)
				<i class="far fa-mail-bulk"></i>
				@else
				<i class="far fa-envelope-open-text"></i>
				@endif
			</td>
			<td>
				@if($contact->read==0)
				<strong>{!!$contact->title!!}</strong>
				@elseif(count($contact->reply)>0)
				{!!$contact->title!!} <span class="badge badge-danger">{!!count($contact->reply)!!}</span>
				@else
				{!!$contact->title!!}
				@endif
			</td>
			<td>
				{!!$contact->customer->fullname!!}<br>
				<small>{!!$contact->customer->email!!} | 
				{!!$contact->customer->mobile!!}</small>
			</td>
			<td>{!!($contact->part)?$contact->part->title:''!!}</td>
			<td>{!!$contact->created_at!!}</td>
			<td>
				<button type="button" class="btn btn-sm btn-primary" onclick="redirectroute('{{ route('contact.admin.viewcontact',$contact->id) }}')"><i class="far fa-eye"></i></button>
				@if(count($contact->reply)==0)
				<button type="button" class="btn btn-sm btn-danger" onclick="delcontact({!!$contact->id!!});"><i class="far fa-trash-alt"></i></button>
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<div class="row my-3">
    <div class="col-sm-5">
        {!!trans('Langcore::global.ShowTotalPage',['firstitem'=>$contacts->firstItem(),'lastitem'=>$contacts->lastItem(),'totalitem'=>$contacts->total()])!!}
    </div>
    <div class="col-sm-7">
        {!! $paginator !!}
    </div>
</div>
@endsection
@section('footer')
<script type="text/javascript" src="{!!asset('modules/js/contact/contact.js.php')!!}"></script>
@endsection