@extends('layouts.master')
@section('metatitle',$new->title)
@section('breadcrumbs')
{{Breadcrumbs::render('module_news_detail',$new)}}
@endsection
@section('header')
@endsection
@section('content')
@include('layouts.flash-message')
<div id="new-detail">
	<h1>{!!$new->title!!}</h1>
	<div class="meta-inner mb-3">
		<div class="post-meta-item">
			<i class="fas fa-user-circle"></i> {!!$new->user->full_name!!}
		</div>
		<div class="post-meta-item">
			<i class="fas fa-calendar-alt"></i> {!!format_time($new->created_at,'d/m/Y')!!}
		</div>
		<div class="post-meta-item">
			<i class="fas fa-eye"></i> {!!$new->views!!}
		</div>
	</div>
	@if($new->image)
	<div class="new-img d-flex justify-content-center mb-3">
		<img src="{!!ThemesFunc::GetThumb($new->image,700);!!}" alt="{!!$new->title!!}" class="img-thumbnail">
	</div>
	@endif
	<div class="content mb-3">
		{!!$new->content!!}
	</div>
	@if($new->keywords)
	<div class="keywords mb-3">
		<span class="font-weight-bold"><i class="fas fa-tags"></i> {!!transmod('News::Tags')!!}:</span>
		@foreach($new->keywords as $key => $keyword)
		<a href="{!!route('search.web.tag',['keyword'=>$keyword])!!}" title="{!!$keyword!!}" rel="tag">{!!$keyword!!}</a>
		{!!($key == count($new->keywords)-1)?'':','!!}
		@endforeach
	</div>
	@endif
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
	<hr>
	<div class="comment">
		{!!Comments::GetViewComments('News',$new)!!}
	</div>
</div>
@endsection
@section('footer')
@endsection