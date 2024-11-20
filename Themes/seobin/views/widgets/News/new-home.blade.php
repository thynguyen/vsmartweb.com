         <div class="row wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
            @foreach($news as $new)
            <div class="col-lg-4 col-md-12">
               <div class="tw-latest-post">
                   @if($new->image)
                  <div class="latest-post-media text-center">
                     <img src="{!!ThemesFunc::GetThumb($new->image,350);!!}" alt="{!!$new->title!!}" class="img-fluid">
                  </div>
                  @endif
                  <div class="post-body">
                     <div class="post-item-date">
                        <div class="post-date">
                           <span class="date">{!!format_time($new->created_at,'d')!!}/{!!format_time($new->created_at,'m')!!}</span>
                           <span class="month">{!!format_time($new->created_at,'Y')!!}</span>
                        </div>
                     </div>
                     <div class="post-info">
                        <div class="post-meta">
                           <span class="post-author">
                              {!!transmod('News::PostedBy')!!}: <a href="#">{!!$new->user->full_name!!}</a>
                           </span>
                        </div>
                        <h3 class="post-title"><a href="{!!route('news.web.detail',['slug'=>$new->slug->slug])!!}" title="{!!$new->title!!}">{!!string_limit_words($new->title,60)!!}</a></h3>
                        <div class="entry-content">
                           <p>
                              {!!string_limit_words($new->description,150)!!}
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach

            <div class="col-md-12 text-center wow zoomIn" data-wow-duration="1s" data-wow-delay="1s"><a href="{!!route('news.web.main')!!}" title="{!!transmod('News::ViewAll')!!}" class="btn btn-primary btn-lg tw-mt-80">{!!transmod('News::ViewAll')!!}</a></div>
         </div>