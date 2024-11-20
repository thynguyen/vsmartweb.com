<div>
	<div class="row">
		@foreach($news as $key => $new)
		<div class="col-sm-{!!(count($news)==1)?12:6!!}">
			<div class="card mb-3">
				<div class="row no-gutters">
					@if($new->image)
					<div class="col-md-4 d-flex justify-content-center align-items-center">
						<img src="{!!ThemesFunc::GetThumb($new->image,200);!!}" class="card-img" alt="{!!$new->title!!}">
					</div>
					@endif
					<div class="col-md-{!!($new->image)?8:12!!}">
						<div class="card-body">
							<h5 class="card-title">
								<a href="{!!route('news.web.detail',['slug'=>$new->slug->slug])!!}" title="{!!$new->title!!}">{!!$new->title!!}</a>
							</h5>
							<p class="card-text">{!!string_limit_words($new->description,200)!!}</p>
							<p class="card-text d-flex justify-content-between">
								<a href="{!!route('news.web.detail',['slug'=>$new->slug->slug])!!}" title="">
									{!!transmod('News::Detail')!!}
								</a>
								<small class="text-muted">{!!format_time($new->created_at,'d/m/Y')!!}</small>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	{!!$paginator!!}
</div>