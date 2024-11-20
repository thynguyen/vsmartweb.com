@extends('layouts.master')
@section('metatitle',$contact->title)
@section('breadcrumbs')
{{Breadcrumbs::render('admin_contact_viewcontact',$contact)}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<div class="card">
	<div class="card-body">
		<h5 class="card-title d-flex align-items-center justify-content-between">
			{!!$contact->title!!}
			<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#sendreply">{!!transmod('contact::SendReply')!!}</button>
		</h5>
		<hr class="mb-1">
		<div class="row">
			<div class="col-sm-6">
				<dl class="row mb-0">
					<dt class="col-sm-3">{!!transmod('contact::Sender')!!}</dt>
					<dd class="col-sm-9">{!!$contact->customer->fullname!!}</dd>
					<dt class="col-sm-3">{!!trans('Langcore::global.Email')!!}</dt>
					<dd class="col-sm-9">{!!$contact->customer->email!!}</dd>
					<dt class="col-sm-3">{!!trans('Langcore::global.Phone')!!}</dt>
					<dd class="col-sm-9">{!!$contact->customer->mobile!!}</dd>
				</dl>
			</div>
			<div class="col-sm-6">
				<dl class="row mb-0">
					<dt class="col-sm-3">IP</dt>
					<dd class="col-sm-9">{!!$contact->ip!!}</dd>
					@if($contact->part)
					<dt class="col-sm-3">{!!transmod('contact::SentDepartment')!!}</dt>
					<dd class="col-sm-9">{!!$contact->part->title!!}</dd>
					@endif
					<dt class="col-sm-3">{!!transmod('contact::SentAt')!!}</dt>
					<dd class="col-sm-9">{!!$contact->created_at!!}</dd>
				</dl>
			</div>
		</div>
		<hr class="mb-1">
		{!!$contact->messenger!!}
	</div>
</div>
<hr>
@foreach($contact->reply as $reply)
<div class="card">
	<ul class="list-group list-group-flush">
		<li class="list-group-item">
			<dl class="row mb-0">
				<dt class="col-sm-2">{!!transmod('contact::Sender')!!}</dt>
				<dd class="col-sm-10">@if($reply->auth){!!($reply->auth->firstname && $reply->auth->lastname)?$reply->auth->lastname.' '.$reply->auth->firstname:$reply->auth->username!!} &lt;{!!$reply->auth->email!!}&gt;@endif</dd>
				<dt class="col-sm-2">{!!transmod('contact::FeedbackTo')!!}</dt>
				<dd class="col-sm-10">{!!$contact->customer->fullname!!} &lt;{!!$contact->customer->email!!}&gt;</dd>
				<dt class="col-sm-2">{!!transmod('contact::FeedbackAt')!!}</dt>
				<dd class="col-sm-10">{!!$reply->created_at!!}</dd>
			</dl>
		</li>
	</ul>
	<div class="card-body">
		{!!$reply->messenger!!}
	</div>
</div>
@endforeach
@endsection
@section('footer')
<div class="modal fade" id="sendreply" tabindex="-1" role="dialog" aria-labelledby="sendreplyLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">
			{!!Form::open(['method' => 'POST', 'route' => ['contact.admin.sendreply',$contact->id], 'enctype'=> 'multipart/form-data'])!!}
				<div class="form-group">
					{!!CKediter::ckediter('messenger',$quote)!!}
				</div>
				<button class="btn btn-sm btn-primary" type="submit">
					<i class="fal fa-paper-plane fa-lg"></i> {{transmod('contact::SendReply')}}
				</button>
			{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
{!!CKediter::ckediterjs('messenger',300)!!}
@endsection