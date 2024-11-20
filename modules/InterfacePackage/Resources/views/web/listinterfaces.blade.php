<div id="interfacepackage">
	<div class="row">
		@foreach($interfaces as $interface)
		<div class="col-sm-4">
			<div class="card mb-4 item-interface">
				<img src="{{$interface->image}}" class="card-img-top" alt="{{$interface->title}}">
				<div class="card-body">
					<h5 class="card-title mb-2"><a href="{{route('interfacepackage.web.detail',['slug'=>$interface->slug])}}" title="{{$interface->title}}" class="link-dark">{{$interface->title}}</a></h5>
					<small class="card-subtitle mb-3 text-muted d-block">
						<span>
							<i class="fal fa-folder mr-2"></i>{{$interface->cat->title}}
						</span>
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
	{!!$paginator!!}
</div>