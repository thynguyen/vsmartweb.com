<footer id="tw-footer" class="tw-footer">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-lg-4">
            <div class="tw-footer-info-box">
               <a href="{{route('indexhome')}}" title="{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}" class="footer-logo">
                  <img src="{{ !empty(CFglobal::cfn('site_logo')) ? CFglobal::cfn('site_logo') : themes('images/logo/logo.png') }}" alt="{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}" title="{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}" class="img-fluid">
               </a>
               <p class="footer-info-text">
                  {!!CFglobal::cfn('site_description')!!}
               </p>
               @WidgetPlace('footer1')
            </div>
            <div class="footer-awarad">
               <img src="{{ themes('images/icon/best.png') }}" alt="">
               <p>V-Smart Web 2020</p>
            </div>
         </div>
         <div class="col-md-12 col-lg-8">
            <div class="row">
               <div class="col-md-6">
                  <div class="contact-us">
                     <div class="contact-icon">
                        <i class="icon icon-map2"></i>
                     </div>
                     <div class="contact-info">
                        <h3>{!!trans('Langcore::global.Address')!!}</h3>
                        <p>{!!CFglobal::cfn('site_address')!!}</p>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="contact-us contact-us-last">
                     <div class="contact-icon">
                        <i class="icon icon-phone3"></i>
                     </div>
                     <div class="contact-info">
                        <h3>{!!CFglobal::cfn('site_phone')!!}</h3>
                        <p>{!!trans('Langcore::global.GiveUsCall')!!}</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row footer-left-widget">
               @WidgetPlace('footer2')
            </div>
         </div>
      </div>
   </div>
   <div class="copyright">
      <div class="container">
         <div class="row">
            <div class="col-md-6">
               <span>@WidgetPlace('copyright')</span>
               <small>{!!trans('Langcore::global.DevelopedBy')!!} <a href="{!!decrypt(encuvsw())!!}" title="V-Smart Web" target="_blank">V-Smart Web</a></small>
            </div>
            <div class="col-md-6">
               <div class="copyright-menu">
                  @WidgetPlace('copyright-menu')
               </div>
            </div>
         </div>
      </div>
   </div>
   <div id="back-to-top" class="back-to-top">
      <button class="btn btn-dark" title="Back to Top">
         <i class="fa fa-angle-up"></i>
      </button>
   </div>
</footer>