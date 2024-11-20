@extends('layouts.master')
@section('metatitle',transmod('EmailMarketing::AddCampaign'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_emailmarketing_addcampaign')}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<div class="card">
	<div class="card-body">
		{!!Form::open(['method' => 'POST', 'route' => ['emailmarketing.admin.addcampaign'], 'enctype'=> 'multipart/form-data'])!!}
		<div class="form-group">
		    {!! Form::text('subject', old('subject'), ['class' => 'form-control','id'=>'subject','placeholder'=>transmod('EmailMarketing::Subject'),'required']) !!}
		</div>
        <div class="form-group">
            {!!CKediter::ckediter('contents',old('contents'))!!}
        </div>
		<div class="form-check checkbox mb-2">
			{!!Form::checkbox('sent',1,true,['class'=>'form-check-input','id'=>'sent'])!!}
			{!!Form::label('sent', transmod('EmailMarketing::SendNow'),['class'=>'form-check-label']);!!}
		</div>
		<button class="btn btn-sm btn-primary" id="btnPost" type="submit" >
			<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
		</button>
		{!! Form::close() !!}
	</div>
</div>
@endsection
@section('footer')
<script type="text/javascript" src="{!!asset('modules/js/emailmarketing/adminemailmarketing.js.php')!!}"></script>
{!!CKediter::ckediterjs('contents',300)!!}
@endsection