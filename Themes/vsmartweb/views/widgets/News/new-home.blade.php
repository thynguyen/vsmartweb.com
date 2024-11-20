
      <div class="mt-5">
         <div class="container">
            <div class="row">
               @foreach($news as $i => $new)
               @if($i<2)
               <div class="col-sm-6 col-lg-4">
                  <div class="article-card mb-4">
                     @if($new->image)
                     <img src="{!!ThemesFunc::GetThumb($new->image,350);!!}" alt="{!!$new->title!!}" class="img-fluid">
                     @endif
                     <span class="mt-3 d-block">
                        <i class="fal fa-calendar-alt"></i> {!!format_time($new->created_at,'d/m/Y')!!}
                     </span>
                     <h4 class="mb-4 mt-2">
                        <a href="{!!route('news.web.detail',['slug'=>$new->slug->slug])!!}" title="{!!$new->title!!}">{!!string_limit_words($new->title,60)!!}</a>
                     </h4>
                     <a href="{!!route('news.web.detail',['slug'=>$new->slug->slug])!!}" title="{!!$new->title!!}" class="btn btn-sm btn-warning px-4 rounded-pill text-uppercase">Chi tiết</a>
                  </div>
               </div>
               @endif
               @endforeach
               <div class="col-sm-12 col-lg-4">
                  @foreach($news as $i => $new)
                  @if($i>=2)
                  <div class="article-card-sm">
                     @if($new->image)
                     <img src="{!!ThemesFunc::GetThumb($new->image,100);!!}" alt="{!!$new->title!!}">
                     @endif
                     <div class="article-card-sm-body">
                        <h6>
                           <a href="{!!route('news.web.detail',['slug'=>$new->slug->slug])!!}" title="{!!$new->title!!}">{!!string_limit_words($new->title,60)!!}</a>
                        </h6>
                        <span class="mt-3 d-block">
                           <i class="fal fa-calendar-alt"></i> {!!format_time($new->created_at,'d/m/Y')!!}
                        </span>
                     </div>
                  </div>
                  @endif
                  @endforeach
               </div>
            </div>
         </div>
      </div>