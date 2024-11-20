@extends('installer::web.master')
@section('header')
<link rel="stylesheet" href="{{ asset('installer/css/style.css') }}">
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-sm-3 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3 pb-5">
      	@GetMenu(2)
      </div>
    </nav>

    <main role="main" class="col-sm-9 ml-sm-auto pb-5 px-md-4 bg-white content-main text-left">
		<div class="text-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">{!!trans('Langcore::installer.ServerRequirements')!!}</h1>
		</div>
		@include('installer::web.flash-message')
	    @foreach($requirements['requirements'] as $type => $requirement)
	        <ul class="list-group">
	            <li class="list-group-item d-flex justify-content-between align-items-center {{ $phpSupportInfo['supported'] ? 'list-group-item-success' : 'list-group-item-warning' }}">
	                <strong>{{ ucfirst($type) }}</strong>
	                @if($type == 'php')
	                    <strong>
	                        <small>
	                            (version {{ $phpSupportInfo['minimum'] }} required)
	                        </small>
	                    </strong>
	                    <span class="float-right">
	                        <strong>
	                            {{ $phpSupportInfo['current'] }}
	                        </strong>
	                        <i class="far fa-fw fa-{{ $phpSupportInfo['supported'] ? 'check-circle' : 'exclamation-circle' }} row-icon" aria-hidden="true"></i>
	                    </span>
	                @endif
	            </li>
	            @foreach($requirements['requirements'][$type] as $extention => $enabled)
                <li class="list-group-item d-flex justify-content-between align-items-center {{ $enabled ? 'list-group-item-success' : 'list-group-item-warning' }}">
                    {{ $extention }}
                    <i class="far fa-fw fa-{{ $enabled ? 'check-circle' : 'exclamation-circle' }} row-icon" aria-hidden="true"></i>
                </li>
	            @endforeach
	        </ul>
	    @endforeach
	    @if ( ! isset($requirements['errors']) && $phpSupportInfo['supported'] )
	    <div class="mt-3 text-center">
		    <a href="{{route('installer.web.permissions')}}" title="{!!trans('Langcore::installer.CheckPermissions')!!}" class="btn btn-sm btn-primary">{!!trans('Langcore::installer.CheckPermissions')!!}</a>
		</div>
	    @endif
    </main>
  </div>
</div>
@endsection
@section('footer')
@endsection