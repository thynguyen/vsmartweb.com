@extends('layouts.master')
@section('metatitle',$new->title)
@section('breadcrumbs')
{{Breadcrumbs::render('module_news_detail',$new)}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<div class="post-content post-single">
   @if($new->image)
   <div class="post-media post-image">
      <img src="{!!ThemesFunc::GetThumb($new->image,700);!!}" alt="{!!$new->title!!}" class="img-fluid">
   </div>
   @endif
   <div class="post-body">
      <div class="entry-header">
         <div class="post-meta">
            <span class="post-meta-date">
               <i class="fal fa-clock"></i> <span class="day">{!!format_time($new->created_at,'d/m/Y')!!}</span>
            </span>
            <span class="post-author">
               <i class="fal fa-user-circle"></i>{!!transmod('News::PostedBy')!!}: <a href="#">{!!$new->user->full_name!!}</a>
            </span>
            <span>
               <i class="fas fa-eye"></i> {!!$new->views!!} {!!transmod('News::Views')!!}
            </span>
            <span class="post-comment">
               <i class="icon icon-comment"></i> {!!$new->comments->count()!!} {!!transmod('News::Comments')!!}
            </span>
         </div>
         <h1 class="entry-title">
            {!!$new->title!!}
         </h1>
      </div>
      <div class="entry-content">
         {!!$new->content!!}
      </div>
      <div class="post-footer clearfix">
         @if($new->keywords)
         <div class="post-tags mb-3">
            <strong><i class="fas fa-tags"></i> {!!transmod('News::Tags')!!}: </strong>
            @foreach($new->keywords as $key => $keyword)
            <a href="{!!route('search.web.tag',['keyword'=>$keyword])!!}" title="{!!$keyword!!}" rel="tag">{!!$keyword!!}</a>
            <!-- {!!($key == count($new->keywords)-1)?'':','!!} -->
            @endforeach
         </div>
         @endif

         <div class="share-items">
            <ul class="post-social-icons unstyled">
               <li><strong>Share: </strong></li>
               <li><a href="#"><i class="fa fa-facebook"></i></a></li>
               <li><a href="#"><i class="fa fa-twitter"></i></a></li>
               <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
               <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
               <li><a href="#"><i class="fa fa-instagram"></i></a></li>
            </ul>
         </div>
      </div>
   </div>
</div>
@if(count($new->othernews)>0)
<hr>
<div class="othernews">
   <ul>
      @foreach($new->othernews as $othernews)
      <li>
         <a href="{!!route('news.web.detail',['slug'=>$othernews->slug->slug])!!}" title="{!!$othernews->title!!}">{!!$othernews->title!!}</a>
      </li>
      @endforeach
   </ul>
</div>
@endif
{!!Comments::GetViewComments('News',$new)!!}
@endsection
@section('footer')
@endsection