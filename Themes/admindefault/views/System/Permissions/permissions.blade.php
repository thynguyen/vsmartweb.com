@extends('layouts.master')
@section('metatitle',trans('Langcore::permissions.Privileges'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_permissions')}}
@endsection
@section('header')
@endsection
@section('content')
<button class="btn btn-brand btn-sm btn-css3" type="button" style="margin-bottom: 4px" onclick="redirectroute('{{ route('infopermissions') }}')">
    <i class="fas fa-plus-square"></i>
    <span>{{trans('Langcore::permissions.AddRole')}}</span>
</button>
@include('layouts.flash-message')
<div id="permissions">
	<div class="card card-body">
		<table class="table table-responsive-sm table-striped table-sm">
			<thead>
				<tr>
					<th></th>
					<th>{{trans('Langcore::permissions.Roles')}}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($list as $key => $permiss)
				<tr>
					<td>
						{{$key+1}}
					</td>
					<td>{{$permiss->name}}</td>
					<td>
						@if($permiss->id>2)
						<div class="btn-group">
							<button class="btn btn-sm btn-primary" type="button" onclick="redirectroute('{{ route('infopermissions',['id'=>$permiss->id]) }}')"><i class="fas fa-edit"></i></button>
							<button class="btn btn-sm btn-danger active"type="button" onclick="delpermission('{{ ($permiss->id==1 or $permiss->id==2)?'':route('delpermissions',['id'=>$permiss->id]) }}','#permissions','{{trans('Langcore::global.warning_delfile')}}')" {{($permiss->id==1 or $permiss->id==2)?'disabled':''}}><i class="fas fa-trash-alt"></i></button>
						</div>
						@elseif($permiss->id==1)
						<span class="text-danger"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span>
						@elseif($permiss->id==2)
						<span class="text-danger"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></span>
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
@endsection
@section('footer')
<script src="{{ asset('js/modules/permission.js') }}"></script>
@endsection