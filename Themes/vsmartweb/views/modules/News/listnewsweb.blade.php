<div>
	@foreach($news as $key => $new)
	<article class="post tw-news-post">
	   @if($new->image)
	   <div class="post-media post-image">
	      <img src="{!!ThemesFunc::GetThumb($new->image,730);!!}" class="img-fluid" alt="{!!$new->title!!}">
	   </div>
	   @endif
	   <div class="post-body">
	      <div class="post-item-date">
	         <div class="post-date">
	         <span class="date">{!!format_time($new->created_at,'d')!!}/{!!format_time($new->created_at,'m')!!}</span>
	         <span class="month">{!!format_time($new->created_at,'Y')!!}</span>
	         </div>
	      </div>
	      <div class="entry-header">
	         <div class="post-meta">
	         <span>
	         <i class="fal fa-user-circle"></i>{!!transmod('News::PostedBy')!!}: <a href="#">{!!$new->user->full_name!!}</a>
	         </span>
	         <span>
	         <i class="fal fa-eye"></i>{!!$new->views!!} {!!transmod('News::Views')!!}
	         </span>
	         <span>
	         	<i class="fal fa-comment-alt-lines"></i>{!!$new->comments->count()!!} {!!transmod('News::Comments')!!}
	         </span>
	         </div>
	         <h2 class="entry-title">
	         <a href="{!!route('news.web.detail',['slug'=>$new->slug->slug])!!}" title="{!!$new->title!!}">{!!$new->title!!}</a>
	         </h2>
	      </div>
	      <div class="entry-content">
	         <p>
	         {!!string_limit_words($new->description,300)!!}
	         </p>
	      </div>
	      <div class="post-footer">
	         <a href="{!!route('news.web.detail',['slug'=>$new->slug->slug])!!}" class="btn btn-dark">{!!transmod('News::Detail')!!} <i class="icon icon-arrow-right"></i></a>
	      </div>
	   </div>
	</article>
	@endforeach
	{!!$paginator!!}
</div>