
  <section id="main-container" class="main-container">
    <div class="container">
       <div class="row">
          <div class="col-6 text-center align-self-center">
             <div class="error-page text-center">
                <div class="error-code">
                   <strong>@yield('code')</strong>
                </div>
                <div class="error-message">
                   <h3 class="text-break">@yield('messageh')</h3>
                </div>
                <div class="error-body">@yield('message')<br>
                   <a href="{{route('indexhome')}}" title="{{trans('Langcore::global.home')}}" class="btn btn-primary solid blank"><i class="fa fa-arrow-circle-left">&nbsp;</i> {{trans('Langcore::global.home')}}</a>
                </div>
             </div>
          </div>
          <div class="col-lg-6 text-right">
             <img class="img-fluid" src="{!!asset('Themes/seobin/assets/images/404.png')!!}" alt="">
          </div>
       </div>
    </div>
  </section>