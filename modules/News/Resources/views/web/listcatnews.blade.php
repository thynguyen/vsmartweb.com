<div>
		@foreach($categorys as $cat)
		@if(count($cat->catpost)>0)
		<div class="mb-3">
			<div class="card">
				<div class="card-header">
					<h3><a href="{!!route('news.web.cat',['slug'=>$cat->slug->slug])!!}" title="{!!$cat->title!!}">{!!$cat->title!!}</a></h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-7">
							<div>
								@if($cat->catpost[0]['news']['image'])
								<a href="{!!route('news.web.detail',['slug'=>$cat->catpost[0]['news']->slug->slug])!!}" title="{!!$cat->catpost[0]['news']['title']!!}"><img src="{!!ThemesFunc::GetThumb($cat->catpost[0]['news']['image'],200);!!}" class="mr-3 float-left" alt="{!!$cat->catpost[0]['news']['title']!!}" ></a>
								@endif
								<div class="media-body">
									<h5 class="mt-0"><a href="{!!route('news.web.detail',['slug'=>$cat->catpost[0]['news']->slug->slug])!!}" title="{!!$cat->catpost[0]['news']['title']!!}">{!!$cat->catpost[0]['news']['title']!!}
</a></h5>
									<p>{!!string_limit_words($cat->catpost[0]['news']['description'],200)!!}</p>

									<a href="{!!route('news.web.detail',['slug'=>$cat->catpost[0]['news']->slug->slug])!!}" title="{!!transmod('News::Detail')!!}">{!!transmod('News::Detail')!!}</a>
								</div>
							</div>
						</div>
						<div class="col-sm-5">
							<ul class="list-unstyled">
								@foreach($cat->catpost as $key => $post)
								@if($key > 0)
									<li class="media my-2">
										<a href="{!!route('news.web.detail',['slug'=>$post->news->slug->slug])!!}" title="{!!$post->news->title!!}" class="d-flex">
											@if($post->news->image)
											<img src="{!!ThemesFunc::GetThumb($post->news->image,60);!!}" class="mr-3" alt="{!!$post->news->title!!}">
											@endif
											<div class="media-body">
												<span class="mt-0 mb-1">{!!string_limit_words($post->news->title,80)!!}</span>
											</div>
										</a>
									</li>
								@endif
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
		@endforeach
		
	{!!$paginator!!}
</div>