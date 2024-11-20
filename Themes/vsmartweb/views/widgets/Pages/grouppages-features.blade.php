<div class="row">
   @foreach($group->pages as $key => $page)
   <div class="col-lg-4 col-md-12 mb-4 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
      <div class="features-box">
         @if($page->image)
         <div class="features-icon d-table">
            <div class="features-icon-inner d-table-cell">
               <img src="{!!ThemesFunc::GetThumb($page->image,250)!!}" alt="{!!$page->title!!}" class="img-fluid">
            </div>
         </div>
         @endif
         <h3><a href="{!!route('pages.web.page',['slug'=>$page->slug->slug])!!}" title="{!!$page->title!!}" class="text-muted">{!!$page->title!!}</a></h3>
         <p>{!!string_limit_words($page->description,100)!!}</p>
         <a href="{!!route('pages.web.page',['slug'=>$page->slug->slug])!!}" title="{!!transmod('Pages::Detail')!!}" class="tw-readmore">{!!transmod('Pages::Detail')!!}
            <i class="fa fa-angle-right"></i>
         </a>
      </div>
   </div>
   @endforeach
</div>