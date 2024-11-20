@extends('layouts.master')
@section('metatitle',$pagetitle)
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_addadmin',$pagetitle)}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
{!!Form::open(['method' => 'POST', 'route' => 'addadmin', 'enctype'=> 'multipart/form-data'])!!}
<div class="card card-accent-primary">
	<div class="card-body">
		<div class="row">
			<div class="col-sm">			
				{!!Form::label('adminname', trans('Langcore::global.Account'), ['class' => 'form-col-form-label']);!!}
				<div class="input-group mb-3">
					{!! Form::text('adminname', $admin['username'],['class'=>'form-control','id'=>'adminname','readonly']) !!}
					<div class="input-group-append">
						{!! Form::button('<i class="fas fa-search"></i>',['class'=>'btn btn btn-secondary','id'=>'btselectuser','type'=>'button','onclick'=>'open_browse("'.route('getlistmember').'","ListMember","800","500","resizable=no,scrollbars=no,toolbar=no,location=no,status=no")',($id>0)?'disabled':'']) !!}
					</div>
				</div>
			</div>
			@if($id>0)
			<div class="col-sm">			
				{!!Form::label('adminemail', 'Email', ['class' => 'form-col-form-label']);!!}
				{!! Form::text('adminemail', $admin['email'], ['class' => 'form-control','id'=>'adminemail']) !!}
			</div>
			@endif
			<div class="col-sm">
				{!!Form::label('name', trans('Langcore::permissions.Roles'), ['class' => 'form-col-form-label']);!!}
				<select name="permis" class="form-control">
					<option value="0">---</option>
					@foreach($listpermis as $key => $permis)
						<option value="{!!$key!!}" {{($admin['in_group'] == $key)?'selected="selected"': ''}}>{!!$permis!!}</option>
					@endforeach
				</select>
			</div>
		</div>
		<button class="btn btn-sm btn-primary" type="submit">
			<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
		</button>
	</div>
</div>
{!! Form::close() !!}
@endsection
@section('footer')
<script src="{{ asset('js/modules/permission.js') }}"></script>
@endsection