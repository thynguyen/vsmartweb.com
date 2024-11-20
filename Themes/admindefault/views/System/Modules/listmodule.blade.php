@extends('layouts.master')
@section('metatitle',trans('Langcore::global.mainModule'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_index_modules')}}
@endsection
@section('header')
	<link href="{{ themes('admindefault:css/modules/modules.css') }}" rel="stylesheet">
@endsection
@section('content')
<button class="btn btn-brand btn-sm btn-google-plus mb-3" type="button" style="margin-bottom: 4px" onclick="javascript:location.href='{{ route('addmodule') }}'">
    <i class="fas fa-plus-square"></i>
    <span>{{trans('Langcore::modules.AddModule')}}</span>
</button>
@include('layouts.flash-message')
<div id="managermodule">
	<div class="row">
		@if($listmodule)
			@foreach($listmodule as $modules => $module)
			<div class="col-sm-6 col-md-3">
				<div class="module-card bg-white border rounded mb-3 position-relative" id="module-{{$module['path']}}">
					<div class="module-body rounded-top p-0">
						<div class="d-flex justify-content-center align-items-center rounded-top p-2 img-module">
							<img src="{{'data:image/png;base64,'.$module['image']}}" class="img-fluid">
						</div>
						<div class="module-name bg-dark text-white px-3 py-2 d-flex justify-content-between">
							<span>{{$module['name']}}</span>
							<div class="d-flex align-items-center">
								@if(count($module['locale'])>0)
									<i class="fas fa-globe fa-lg mr-2" data-container="body" data-toggle="popover" data-placement="bottom" data-content="@foreach($module['locale'] as $loca => $locale)
									<img src='{{ asset('images/flags/'. getCountry($locale) .'.png') }}' alt='{{ $locale }}' width='{{ config('laravellocalization.flags.width') }}' />
								@endforeach" data-html="true" title=""></i>
								@endif
								@if(!empty($module['pathmod']))
								<label class="switch switch-pill switch-outline-primary-alt switch-sm align-middle mb-0" data-path="{{$module['path']}}">
									<input class="switch-input" type="checkbox"  onchange="actionsys('{{ route('activemod',$module['path']) }}','.sidebar-nav','#managermodule');" {{($module['active'])? 'checked=""':''}}>
									<span class="switch-slider"></span>
								</label>
								@endif
							</div>
						</div>
					</div>
					<div class="module-footer px-3 py-2">
						<ul class="list-unstyled m-0">
							@if($module['description'])
							<li class="text-muted mb-2">{{$module['description']}}</li>
							@endif
							<li>{{trans('Langcore::global.author')}} {{$module['author']}}</li>
							<li>{{trans('Langcore::global.version')}} <span class="text-danger font-weight-bold">{{$module['version']}}</span></li>
						</ul>
						<div class="button btn-group d-flex justify-content-end my-2 text-right">
							@if(!empty($module['pathmod']))
							<button class="btn btn-sm btn-success" onclick="redirectroute('{{ route('infomod',$module['path']) }}')" type="button" aria-pressed="true"><i class="fas fa-edit"></i> {{trans('Langcore::global.Edit')}}</button>
							<button class="btn btn-sm btn-danger" onclick="reinstallmod('{{$module['path']}}')" type="button" aria-pressed="true">{{trans('Langcore::modules.Reinstall')}}</button>
							@endif
							@if($module['pathmod'])
							<button class="btn btn-sm actionsys btn-warning" onclick="uninstallmod('{{$module['path']}}')" type="button" aria-pressed="true">{{trans('Langcore::global.Uninstall')}}</button>
							@else
							<button class="btn btn-sm actionsys btn-primary active" onclick="installmod('{{$module['path']}}')" type="button" aria-pressed="true">{{trans('Langcore::global.Install')}}</button>
							@endif
							@if(empty($module['pathmod']))
							<button class="btn btn-sm btn-danger active" onclick="deletesys('{{ route('delmod',$module['path']) }}','#managermodule','.sidebar-nav','{{trans('Langcore::global.warning_delfile')}}');" type="button" aria-pressed="true" {{(count($module['locale'])>0)?'disabled':''}}>{{trans('Langcore::global.Delete')}}</button>
							@endif
						</div>
					</div>
				</div>
			</div>
			@endforeach
		@else
			<div class="col-sm-12">
				<div class="card card-accent-primary">
					<div class="card-body text-center">
						<i class="fas fa-robot fa-2x"></i> {{trans('Langcore::modules.EmptyModule')}}
					</div>
				</div>
			</div>
		@endif
	</div>
</div>
@endsection
@section('footer')
<script type="text/javascript">
	function installmod(modulename) {
		$('#module-'+modulename).append('<div id="maskpin"><div class="loading rounded"><i class="fas fa-spinner fa-spin mr-1"></i> Installing...</div><div class="maskbg rounded"></div></div>');
		window.location.href=route('infomod',{module:modulename});
	}
	function reinstallmod(modulename) {
	    if (confirm('Are You Sure?') == true) {
			$('#module-'+modulename).append('<div id="maskpin"><div class="loading rounded"><i class="fas fa-spinner fa-spin mr-1"></i> Reinstalling...</div><div class="maskbg rounded"></div></div>');
			$.ajax({
		        url: route('reinstallmod'),
		        type: 'POST',
		        contentType: "application/x-www-form-urlencoded;charset=utf-8",
		        data: {
		          _token: csrf_token,
		          module:modulename
		        },
		        success: function(result) {
		        	$('#maskpin').remove();
		            new PNotify({
		                title: "Done",
		                text: result,
		                type: "success",
		            });
		        }
		    });
		}
	}


	function uninstallmod(modulename) {
	    if (confirm('Are You Sure?') == true) {

			$('#module-'+modulename).append('<div id="maskpin"><div class="loading rounded"><i class="fas fa-spinner fa-spin mr-1"></i> Uninstalling...</div><div class="maskbg rounded"></div></div>');
	    	$.ajax({
	            url: route('uninstallmod'),
	            type: 'POST',
	            contentType: "application/x-www-form-urlencoded;charset=utf-8",
	            data: {
		          _token: csrf_token,
		          module:modulename
	            },
	            success: function(result) {
	            	b = '#module-'+modulename;
	            	$( b ).load(window.location.href + " "+b+" > *");
	                new PNotify({
	                    title: "Done",
	                    text: result,
	                    type: "success",
	                });
	            },
	            error: function(result, status, error) {
	                var err = JSON.parse(result.responseText);
	                new PNotify({
	                    title: "Error",
	                    text: err,
	                    type: "warning"
	                });
	            }
	        });
	    }
	}
</script>
@endsection