<div class="row">
   @foreach($group->pages as $key => $page)
   <div class="col-md-4 mb-4 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
      <div class="tw-case-study-box">
         @if($page->image)
         <div class="case-img wg-case-minheight study-bg-{!!$key+1!!}">
            <img src="{!!ThemesFunc::GetThumb($page->image,350)!!}" alt="{!!$page->title!!}" class="img-fluid">
         </div>
         @endif
         <div class="casestudy-content">
            <a href="{!!route('pages.web.page',['slug'=>$page->slug->slug])!!}" title="{!!$page->title!!}">
               <h4>{!!$page->title!!}</h4>
            </a>
            <p>{!!string_limit_words($page->description,100)!!}</p>
         </div>
      </div>
   </div>
   @endforeach
   <div class="col-md-12 text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.4s"><a href="{!!route('pages.web.group',['slug'=>$group->slug->slug])!!}" class="btn btn-primary btn-lg tw-mt-80" title="{!!transmod('Pages::ViewMore')!!}">{!!transmod('Pages::ViewMore')!!}</a></div>
</div>