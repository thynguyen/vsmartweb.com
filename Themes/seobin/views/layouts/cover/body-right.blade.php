<section id="main-container" class="main-container">
  <div class="container">
     <div class="row">
        <div class="col-lg-8 col-md-12">
           @WidgetPlace('header')
           @yield('content')
           @WidgetPlace('bottom')
        </div>
        <div class="col-lg-4 col-md-12">
           <div class="sidebar sidebar-right">
              @WidgetPlace('right')
           </div>
        </div>
     </div>
  </div>
</section>