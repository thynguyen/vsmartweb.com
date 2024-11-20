   <section id="tw-intro" class="tw-intro-area">
      <div class="tw-ellipse-pattern">
         <img src="{{ themes('images/about_ellipse.png') }}" alt="">
      </div>
      <div class="container">
         <div class="row">
            @if($page->image)
            <div class="col-lg-6 col-md-12 text-lg-right text-md-center wow fadeInLeft" data-wow-duration="1s">
               <img src="{!!ThemesFunc::GetThumb($page->image,500)!!}" alt="{!!$page->title!!}" class="img-fluid">
            </div>
            @endif
            <div class="col-lg-{!!($page->image)?5:12!!} ml-auto col-md-12 wow fadeInRight" data-wow-duration="1s">
               <h2 class="column-title">{!!$page->title!!}</h2>
               <span class="animate-border tw-mb-40"></span>
               <p>
                  {!!$page->description!!}
               </p>
               <a href="{!!route('pages.web.page',['slug'=>$page->slug->slug])!!}" title="{!!transmod('Pages::Detail')!!}" class="btn btn-primary">{!!transmod('Pages::Detail')!!}</a>
            </div>
         </div>
      </div>
   </section>