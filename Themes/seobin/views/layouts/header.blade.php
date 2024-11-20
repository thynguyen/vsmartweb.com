	@WidgetPlace('search')
	<div class="tw-top-bar">
		<div class="container">
			<div class="row">
				<div class="col-md-8 text-left">
					<div class="top-contact-info">
						<span><i class="icon icon-phone3"></i>{!!CFglobal::cfn('site_phone')!!}</span>
						<span><i class="icon icon-envelope"></i>{!!CFglobal::cfn('site_email')!!}</span>
						<span><i class="icon icon-map-marker2"></i>{!!CFglobal::cfn('site_address')!!}</span>
					</div>
				</div>
				<div class="col-md-4 ml-auto text-right">
					@WidgetPlace('social')
				</div>
			</div>
		</div>
	</div>
	<header>
		<div class="tw-head">
			<div class="container">
				<nav class="navbar navbar-expand-lg navbar-light bg-white">
					<a class="navbar-brand tw-nav-brand" href="{{route('indexhome')}}" title="{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}">
					<img src="{{ !empty(CFglobal::cfn('site_logo')) ? CFglobal::cfn('site_logo') : themes('images/logo/logo.png') }}" alt="{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}" title="{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}">
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
					aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
						@WidgetPlace('menusite')
					</div>
					<div class="tw-off-search d-none d-lg-inline-block">
						<div class="tw-search">
							<i class="fa fa-search"></i>
						</div>
						@if(count(LanguageFunc::GetAllLang())>=2)
						<div class="tw-language dropdown">
			                <a data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true"> <img src="{{ asset('images/flags') }}/@LangCurrent('flag').png" alt="@LangCurrent('name')" width="22px"> </a>
			                <div class="dropdown-menu dropdown-menu-right">
			                  @foreach (LanguageFunc::GetAllLang() as $lang)
			                  <a class="dropdown-item" hreflang="{{ $lang['locale'] }}" href="{{ LaravelLocalization::getLocalizedURL($lang['locale'], route('indexhome'), [], true) }}"> <img src="{{ asset('images/flags/'. strtoupper($lang['flag']) .'.png') }}" alt="{{ $lang['name'] }}" width="22px" /> &nbsp; {{ $lang['name'] }} </a>
			                  @endforeach
			                </div>
			            </div>
			            @endif
					</div>
				</nav>
			</div>
		</div>
	</header>
	@yield('breadcrumbs')