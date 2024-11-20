<div class="row">
   @foreach($group->pages as $page)
   <div class="col-md-4 text-center mb-3">
      <div class="tw-service-box wow zoomIn" data-wow-duration="1s" data-wow-delay=".2s">
         @if($page->image)
         <div class="service-icon service-icon-bg-1 d-table">
            <div class="service-icon-inner d-table-cell">
               <img src="{!!ThemesFunc::GetThumb($page->image,90)!!}" alt="{!!$page->title!!}" class="img-fluid">
            </div>
         </div>
         @endif
         <div class="service-content">
            <h3>{!!$page->title!!}</h3>
            <p>{!!string_limit_words($page->description,100)!!}</p>
            <a href="{!!route('pages.web.page',['slug'=>$page->slug->slug])!!}" title="{!!transmod('Pages::Detail')!!}" class="tw-readmore">{!!transmod('Pages::Detail')!!}
               <i class="fa fa-angle-right"></i>
            </a>
         </div>
      </div>
   </div>
   @endforeach
</div>