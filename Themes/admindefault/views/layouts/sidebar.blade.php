<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}"> <i class="nav-icon icon-speedometer"></i> {{lang('content.dashboard')}} </a>
      </li>
      <!-- Menu Module -->
      @if(AdminFunc::AdminMenu('modules'))
        @foreach(AdminFunc::AdminMenu('modules') as $adsystemmenus)
          @foreach($adsystemmenus as $systemmenus)      
            @if($systemmenus)
              @if($systemmenus['active'] && AdminFunc::ModPerMS(AdminFunc::ReturnModule($systemmenus['path'],'pathmod')))
              <li class="nav-item{{($systemmenus['submenu'])?' nav-dropdown':''}}">
                <a class="nav-link{{($systemmenus['submenu'])?' nav-dropdown-toggle':''}}" href="{{($systemmenus['submenu'])?'#': $systemmenus['route']}}">{!!$systemmenus['icon']!!} {!!$systemmenus['title']!!}</a>
                  @if($systemmenus['submenu'])
                  <ul class="nav-dropdown-items">
                    @foreach($systemmenus['submenu'] as $submenu)
                    <li class="nav-item">
                      <a class="nav-link" href="{{ $submenu['route'] }}">{!!$submenu['icon']!!} {!!$submenu['title']!!}</a>
                    </li>
                    @endforeach
                  </ul>
                  @endif
              </li>
              @endif
            @endif
          @endforeach
        @endforeach
      @endif
      <!-- End Menu Module -->
      <!-- Menu System -->
      @if(Auth::check() && Auth::user()->in_group <= 2)
        @if(AdminFunc::AdminMenu('core/System'))
          <li class="nav-title">
            {{trans('Langcore::global.System')}}
          </li>
          @foreach(AdminFunc::AdminMenu('core/System') as $adsystemmenus)
            @foreach($adsystemmenus as $systemmenus)          
              @if($systemmenus && AdminFunc::AdminPerMS($systemmenus['permission']))
              <li class="nav-item{{($systemmenus['submenu'])?' nav-dropdown':''}}">
                <a class="nav-link{{($systemmenus['submenu'])?' nav-dropdown-toggle':''}}" href="{{($systemmenus['submenu'])?'#': $systemmenus['route']}}">{!!$systemmenus['icon']!!} {!!$systemmenus['title']!!}</a>
                  @if($systemmenus['submenu'])
                  <ul class="nav-dropdown-items">
                    @foreach($systemmenus['submenu'] as $submenu)
                    @if(AdminFunc::AdminPerMS($submenu['permission']))
                    <li class="nav-item">
                      <a class="nav-link" href="{{ $submenu['route'] }}">{!!$submenu['icon']!!} {!!$submenu['title']!!}</a>
                    </li>                    
                    @endif
                    @endforeach
                  </ul>
                  @endif
              </li>
              @endif
            @endforeach
          @endforeach
        @endif
      @endif
      <!-- End Menu System -->
    </ul>
  </nav>
  <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>