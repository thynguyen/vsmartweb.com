@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('Contact','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_contact_parts')}}
@endsection
@section('header')
<link rel="stylesheet" type="text/css" href="{{ asset('modules/css/contact/contact.css.php') }}">
@endsection
@section('content')
@include('layouts.flash-message')
<div class="mb-3">
	<button type="button" onclick="addpart();" class="btn btn-sm btn-primary">{!!transmod('contact::AddPart')!!}</button>
</div>
<table class="table table-responsive-sm table-striped mb-0 bg-white">
	<thead class="thead-dark">
		<tr>
			<th>{!!transmod('contact::Parts')!!}</th>
			<th>{!!trans('Langcore::global.Phone')!!}</th>
			<th>{!!trans('Langcore::global.Email')!!}</th>
			<th></th>
		</tr>
	</thead>
    <tbody>
		@foreach($parts as $part)
		<tr id="part{!!$part->id!!}" class="position-relative">
			<td>{!!$part->title!!}</td>
			<td>{!!$part->mobile!!}</td>
			<td>{!!$part->email!!}</td>
			<td>
				<button type="button" onclick="addpart('{!!$part->id!!}');" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></button>
                <button type="button" class="btn btn-sm btn-danger" onclick="delpart('{!!$part->id!!}');"><i class="fas fa-trash-alt"></i></button>
			</td>
		</tr>
		@endforeach
    </tbody>
</table>
@endsection
@section('footer')
<script src="{{ asset('modules/js/contact/contact.js.php') }}"></script>
<div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id="addpart">
        </div>
    </div>
</div>
<div class="modal fade" id="addrecipients" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
@endsection