<section id="about-home" class="py-5">
   <div class="container">
      <div class="row align-items-center justify-content-between">
         @if($page->image)
         <div class="col-sm-5 col-lg-5">
            <img src="{!!ThemesFunc::GetThumb($page->image,500)!!}" alt="{!!$page->title!!}" class="img-fluid mb-3">
         </div>
         @endif
         <div class="{!!($page->image)?'col-sm-7 col-lg-6':'col-12'!!}">
            <h2 class="mb-3">{!!$page->title!!}</h2>
            <p>{!!$page->description!!}</p>
            <a href="{!!route('pages.web.page',['slug'=>$page->slug->slug])!!}" title="{!!transmod('Pages::Detail')!!}" class="btn btn-warning rounded-pill px-5 shadow my-4 fw-bold fs-5">{!!transmod('Pages::Detail')!!}</a>
         </div>
      </div>
   </div>
</section>