<header class="app-header navbar">
  <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="{{ route('adminindex') }}"> <img class="navbar-brand-full" src="{{ asset('images/logo_vsw.png') }}" width="89" height="25" alt="V-Smart Web"> <img class="navbar-brand-minimized" src="{{ asset('images/icon_vsw.png') }}" width="30" height="30" alt="V-Smart Web"> </a>
  <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
    <span class="navbar-toggler-icon"></span>
  </button>
  <ul class="nav navbar-nav ml-auto">
    @if(count(LanguageFunc::GetAllLang())>=2)
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-language"></i> </a>
      <div class="dropdown-menu dropdown-menu-right">
        @foreach (LanguageFunc::GetAllLang() as $lang)
        <a class="dropdown-item" hreflang="{{ $lang['locale'] }}" href="{{ LaravelLocalization::getLocalizedURL($lang['locale'], null, [], true) }}"> <img src="{{ asset('images/flags/'. strtoupper($lang['flag']) .'.png') }}" alt="{{ $lang['name'] }}" width="22px" /> &nbsp; {{ $lang['name'] }} </a>
        @endforeach
      </div>
    </li>
    @endif
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> <img class="img-avatar" src="@if(!empty(Auth::user()->avatar)) {{ Auth::user()->avatar }} @else {{ Avatar::create(Auth::user()->username)->toBase64() }} @endif" alt="{{ Auth::user()->username }}"> </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="{{ route('logout') }}"> <i class="fa fa-lock"></i>{{lang('content.logout')}}</a>
      </div>
    </li>
  </ul>
</header>