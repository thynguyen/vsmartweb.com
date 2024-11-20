@extends($getlayout)
@section('metatitle',$page->title)
@section('breadcrumbs')
{{Breadcrumbs::render('module_pages_page',$page)}}
@endsection
@section('content')
<div class="blog_area single-post-area">
	<div class="single-post">
		<div class="blog_details">
			<h1 class="h3">{!!$page->title!!}</h1>
			<ul class="blog-info-link mt-3 mb-4">
				<li>
					<i class="far fa-user"></i> {!!$page->auth!!}
				</li>
				<li>
					<i class="far fa-eye"></i> {{$page->views}} {{trans('Langcore::global.PageViews')}}
				</li>
			</ul>
			{!!json_decode($page->content->content)!!}
		</div>
	</div>
</div>
@endsection