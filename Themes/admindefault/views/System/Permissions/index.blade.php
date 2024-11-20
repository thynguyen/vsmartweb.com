@extends('layouts.master')
@section('metatitle',trans('Langcore::permissions.Administrators'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_listadmin')}}
@endsection
@section('header')
@endsection
@section('content')
<button class="btn btn-brand btn-sm btn-css3" type="button" style="margin-bottom: 4px" onclick="redirectroute('{{ route('addadmin') }}')">
    <i class="fas fa-plus-square"></i>
    <span>{{trans('Langcore::permissions.AddRole')}}</span>
</button>
@include('layouts.flash-message')
<div class="card card-body">
	<div id="ajaxadmin">
		@include('System.Permissions.ajaxindex')
	</div>
</div>
@endsection
@section('footer')
<script src="{{ asset('js/modules/permission.js') }}"></script>
<script type="text/javascript">$(document).ready(function(){$(document).on('click', '.pagination a',function(event){event.preventDefault(); $('li').removeClass('active'); $(this).parent('li').addClass('active'); var myurl=$(this).attr('href'); var page=$(this).attr('href').split('page=')[1]; getData(page,"#ajaxadmin");});});</script>
@endsection