<div id="interfacepackage">
	@foreach($categorys as $category)
	<div class="d-flex justify-content-between mb-4">
		<h4 class="fs-5 fw-bold"><i class="{{$category->icon}} fa-fw mr-2"></i>{{$category->title}}</h4>
		<a href="{{route('interfacepackage.web.viewcat',['slug'=>$category->slug])}}" class="btn btn-sm btn-primary">Xem thêm</a>
	</div>
	<div class="row mb-5">
		@foreach($category->interface as $interface)
		<div class="col-sm-3">
			<div class="card">
				<img src="{{$interface->image}}" class="card-img-top" alt="{{$interface->title}}">
				<div class="card-body">
					<h5 class="card-title"><a href="{{route('interfacepackage.web.detail',['slug'=>$interface->slug])}}" title="{{$interface->title}}" class="link-dark">{{$interface->title}}</a></h5>
					<small class="card-subtitle mb-3 text-muted d-block">
						<span>
							<i class="fal fa-thumbs-up mr-2"></i>{{$interface->sentimentlike->count()}}
						</span>
						<span>
							<i class="fal fa-thumbs-down mr-2"></i>{{$interface->sentimentdislike->count()}}
						</span>
					</small>
					<p class="card-text">{{string_limit_words($interface->description,200)}}</p>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	@endforeach
	{!!$paginator!!}
</div>