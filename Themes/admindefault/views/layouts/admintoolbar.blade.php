<div class="position-fixed w-100" id="admintoolbar">
	<div class="d-flex justify-content-between align-items-center bg-info">
		<div class="menu-toolbar py-1">
			<a href="{!!decrypt(encuvsw())!!}" title="V-Smart Web" class="border-right-0" target="_blank"><img src="{{ asset('images/icon_vsw_w.png') }}" alt="V-Smart Web"></a>
			<a href="{{route('adminindex')}}" class="text-white">
				<i class="fas fa-tachometer-alt"></i> {{trans('Langcore::global.dashboard')}}
			</a>
			<a href="{{route('runtoolwidget')}}" class="text-white">
				{{trans('Langcore::themes.ManagerWidget')}}
				<span class="badge bg-{{(session('toolwidget') == 'on')?'danger':'secondary'}}">{{(session('toolwidget') == 'on')?trans('Langcore::global.On'):trans('Langcore::global.Off')}}</span>
			</a>
		</div>
		<div class="auth-avatar bg-dark d-flex align-items-center border-left px-3 py-1">
			<div class="dropdown">
				<a class="text-white" href="#" role="button" id="profile-admin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="mr-2 text-uppercase font-weight-bold">{{ Auth::user()->username }}</span><img class="img-avatar rounded-circle mr-2" src="@if(!empty(Auth::user()->avatar)) {{ Auth::user()->avatar }} @else {{ Avatar::create(Auth::user()->username)->toBase64() }} @endif" alt="{{ Auth::user()->username }}"> </a>
				<div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="profile-admin">
					<a class="dropdown-item" href="#"> <i class="fa fa-user"></i> {{trans('Langcore::global.my_profile')}}</a>
					<div class="dropdown-divider"></div>
        			<a class="dropdown-item" href="{{ route('logout') }}"> <i class="fa fa-lock"></i> {{trans('Langcore::global.Logout')}}</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div style="height: 40px"></div>