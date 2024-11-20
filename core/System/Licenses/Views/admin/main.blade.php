@extends('layouts.master')
@section('metatitle',trans('Langcore::licenses.LicensingManagement'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_licenses')}}
@endsection
@section('header')
<link rel="stylesheet" type="text/css" href="{{ asset('css/datetimepicker-master/jquery.datetimepicker.min.css') }}"/ >
@endsection
@section('content')
<div class="mb-3">
	<button type="button" class="btn btn-sm btn-primary" onclick="licenseregister();">{!!trans('Langcore::licenses.SignUpLicense')!!}</button>
</div>
<table class="table table-responsive-sm table-striped bg-white" id="listlicense">
	<thead>
		<tr>
			<th></th>
			<th>{{trans('Langcore::licenses.License')}}</th>
			<th>{!!trans('Langcore::licenses.Domain')!!}</th>
			<th>{!!trans('Langcore::licenses.StartDay')!!}</th>
			<th>{!!trans('Langcore::licenses.ExpirationDate')!!}</th>
			<th>{!!trans('Langcore::licenses.Note')!!}</th>
			<th width="180">{!!trans('Langcore::licenses.Status')!!}</th>
			<th width="100"></th>
		</tr>
	</thead>
	<tbody>
		@foreach($licenses as $license)
		<tr id="license{!!$license->id!!}">
			<td>
				<button type="button" class="btn btn-sm btn-primary" onclick="licenseregister('{!!$license->id!!}')"><i class="fal fa-pen"></i></button>
			</td>
			<td>{!!$license->license!!}</td>
			<td>{!!$license->domain!!}</td>
			<td>{!!$license->start_day!!}</td>
			<td>{!!$license->expiration_date!!}</td>
			<td>{!!$license->message!!}</td>
			<td>
	        {!!Form::select('status', $status, $license->status, ['class' => 'form-control','id'=>'status'.$license->id,'onchange'=>"changestatus('".$license->id."')"])!!}</td>
	        <td>
	        	<button type="button" class="btn btn-sm btn-danger" onclick="dellicense('{!!$license->id!!}');"><i class="fal fa-trash-alt"></i></button>
	        </td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection
@section('footer')
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<script src="{{ asset('js/modules/licenses.js') }}"></script>
<script src="{{ asset('js/datetimepicker-master/jquery.datetimepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function(){
        jQuery.datetimepicker.setLocale('{!!LaravelLocalization::getCurrentLocale()!!}');
    });
</script>
@endsection