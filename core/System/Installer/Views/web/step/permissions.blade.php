@extends('installer::web.master')
@section('header')
<link rel="stylesheet" href="{{ asset('installer/css/style.css') }}">
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-sm-3 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3 pb-5">
      	@GetMenu(3)
      </div>
    </nav>

    <main role="main" class="col-sm-9 ml-sm-auto pb-5 px-md-4 bg-white content-main text-left">
		<div class="text-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2">{!!trans('Langcore::installer.CheckPermissions')!!}</h1>
		</div>
		@include('installer::web.flash-message')
	    <ul class="list-group">
	        @foreach($permissions['permissions'] as $permission)
	        <li class="list-group-item d-flex justify-content-between align-items-center {{ $permission['isSet'] ? 'list-group-item-success' : 'list-group-item-warning' }}">
	            {{ $permission['folder'] }}
	            <span>
	                <i class="far fa-fw fa-{{ $permission['isSet'] ? 'check-circle' : 'exclamation-circle' }}"></i>
	                {{ $permission['permission'] }}
	            </span>
	        </li>
	        @endforeach
	    </ul>
	    @if ( ! isset($permissions['errors']))
	    <div class="mt-3 text-center">
		    <a href="{{route('installer.web.database')}}" title="{!!trans('Langcore::installer.Database')!!}" class="btn btn-sm btn-primary">{!!trans('Langcore::installer.Database')!!}</a>
		</div>
		@endif
    </main>
  </div>
</div>
@endsection
@section('footer')
@endsection