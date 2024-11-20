<div class="menu-body visibility">
  @WidgetPlace('menumobile')
</div>
<header class="w-100 position-absolute py-3" data-bghead="bg-primary bg-gradient">
  <div class="container">
     <div class="row d-flex align-items-center">
        <div class="col-lg-2 col-sm-7 col-9">
           <div class="logo py-2 d-flex justify-content-between">
              <button type="button" class="b-block d-lg-none btnnbd text-white menu-trigger"><i class="fal fa-bars fa-2x"></i></button>
              <a href="{{route('indexhome')}}" title="{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}">
                 <img src="{{ !empty(CFglobal::cfn('site_logo')) ? CFglobal::cfn('site_logo') : themes('img/logo.png') }}" alt="{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}" class="img-fluid">
              </a>
           </div>
        </div>
        <div class="col-lg-10 col-sm-5 col-3 d-flex justify-content-end align-items-center">
           <nav class="menusite mr-3 d-none d-lg-block">
              @WidgetPlace('menusite')
           </nav>
           <div class="search mr-lg-3">
              @WidgetPlace('search')
           </div>
           <div class="client-area">
              @WidgetPlace('client-area')
           </div>
        </div>
     </div>
  </div>
</header>
@yield('breadcrumbs')