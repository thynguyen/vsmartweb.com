<div>
   <div class="row">
      @foreach($pages as $key => $page)
      <div class="col-sm-4 mb-4">
         <div class="tw-service-box-list text-center">
            @if($page->image)
            <div class="service-list-bg service-list-bg-{!!$key+1!!} d-table">
               <div class="service-list-icon d-table-cell">
                  <img src="{!!ThemesFunc::GetThumb($page->image,200)!!}" alt="{!!$page->title!!}" class="img-fluid">
               </div>
            </div>
            @endif
            <h3><a href="{!!route('pages.web.page',['slug'=>$page->slug->slug])!!}" title="{!!transmod('Pages::Detail')!!}" class="text-muted">{!!$page->title!!}</a></h3>
            <p>{!!string_limit_words($page->description,100)!!}</p>
            <a href="{!!route('pages.web.page',['slug'=>$page->slug->slug])!!}" title="{!!transmod('Pages::Detail')!!}" class="tw-readmore">{!!transmod('Pages::Detail')!!}
               <i class="fa fa-angle-right"></i>
            </a>
         </div>
      </div>
      @endforeach
   </div>
   <div class="mt-3">
      {!!$paginator!!}
   </div>
</div> 