@extends('layouts.master')
@section('metatitle',$pagetitle)
@section('breadcrumbs')
{!!Breadcrumbs::render('admin_index_infopermissions',$pagetitle)!!}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
@if($id>0)
	{!!Form::open(['method' => 'POST', 'route' => ['infopermissions', 'id'=>$id], 'enctype'=> 'multipart/form-data'])!!}
@else
	{!!Form::open(['method' => 'POST', 'route' => 'infopermissions', 'enctype'=> 'multipart/form-data'])!!}
@endif
	<div class="card card-accent-primary">
		<div class="card-body was-validated">		
			<div class="form-group">
				{!!Form::label('name', trans('Langcore::permissions.NamOfRole'), ['class' => 'form-col-form-label']);!!}
				{!! Form::text('name', !empty($data->id)? $data->name :'', ['class' => 'form-control is-invalid','id'=>'name','required']) !!}
				@if ($errors->has('name'))
				<div class="invalid-feedback">
					{{ $errors->first('name') }}
				</div>
				@endif
			</div>
			@if($id==0 or $id > 2)
			<table class="table table-responsive-sm table-striped">
				<thead class="thead-dark">
					<tr>
						<th></th>
						<th>{{trans('Langcore::permissions.NameMod')}}</th>
						<th></th>
						<th class="text-center">{{trans('Langcore::permissions.View')}}</th>
						<th class="text-center">{{trans('Langcore::permissions.Add')}}</th>
						<th class="text-center">{{trans('Langcore::permissions.Delete')}}</th>
					</tr>
				</thead>
				<tbody>
					<tr class="table-info">
						<td></td>
						<td></td>
						<td class="text-center">Check All</td>
						<td class="align-top"><div class="form-check checkbox text-center">{!!Form::checkbox(null,null,false,['class'=>'form-check-input','id'=>'view'])!!}</div></td>
						<td class="align-top"><div class="form-check checkbox text-center">{!!Form::checkbox(null,null,false,['class'=>'form-check-input','id'=>'add'])!!}</div></td>
						<td class="align-top"><div class="form-check checkbox text-center">{!!Form::checkbox(null,null,false,['class'=>'form-check-input','id'=>'delete'])!!}</div></td>
					</tr>
					@foreach($modules as $key => $module)
					<tr>
						<td>{{$key+1}}</td>
						<td>{{$module['title']}} {!!($module['active']==0)?'<span class="badge badge-danger">'.trans('Langcore::permissions.NotActivated').'</span>':''!!}</td>
						<td class="table-info">
							<div class="form-check checkbox text-center">{!!Form::checkbox(null,null,false,['class'=>'form-check-input checkmod',($module['active']==0)?'disabled':''])!!}</div>
						</td>
						<td class="table-warning">
							<div class="form-check checkbox text-center">{!!Form::checkbox('rolemod['.$module['path'].'][view]',1,($module['rule']['view']==1 && $module['active']==1)?true:false,['class'=>'form-check-input view',($module['active']==0)?'disabled':''])!!}</div>
						</td>
						<td class="table-primary">
							<div class="form-check checkbox text-center">{!!Form::checkbox('rolemod['.$module['path'].'][add]',1,($module['rule']['add']==1 && $module['active']==1)?true:false,['class'=>'form-check-input add',($module['active']==0)?'disabled':''])!!}</div>
						</td>
						<td class="table-danger">
							<div class="form-check checkbox text-center">{!!Form::checkbox('rolemod['.$module['path'].'][delete]',1,($module['rule']['delete']==1 && $module['active']==1)?true:false,['class'=>'form-check-input delete',($module['active']==0)?'disabled':''])!!}</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@endif
			<button class="btn btn-sm btn-primary" type="submit">
				<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
			</button>
		</div>
	</div>
{!! Form::close() !!}
@endsection
@section('footer')
<script>
	$(function() {
		$("#view").click(function() {
			var is_ch = $(this).prop('checked');
			$(".view").prop("checked", is_ch);
		});
		$('.view').click(function() {
			if ($('.view:checked').length == $('.view').length) {
				$('#view').prop('checked', true);
			} else {
				$('#view').prop('checked', false);
			}
		});

		$("#add").click(function() {
			var is_ch = $(this).prop('checked');
			$(".add").prop("checked", is_ch);
		});
		$('.add').click(function() {
			if ($('.add:checked').length == $('.add').length) {
				$('#add').prop('checked', true);
			} else {
				$('#add').prop('checked', false);
			}
		});
		$("#delete").click(function() {
			var is_ch = $(this).prop('checked');
			$(".delete").prop("checked", is_ch);
		});
		$('.delete').click(function() {
			if ($('.delete:checked').length == $('.delete').length) {
				$('#delete').prop('checked', true);
			} else {
				$('#delete').prop('checked', false);
			}
		});
		$(".checkmod").click(function() {
			var p = $(this).parents('tr');
			var is_ch = $(this).is(':checked');
			p.find("input[type=checkbox]").prop("checked", is_ch);
		});
	})
</script>
@endsection