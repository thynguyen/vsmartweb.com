@if($interfacecat)
<div class="container-fluid">
	<div class="row">
		@foreach($interfacecat as $item)
		<div class="col-sm-4 list-templates mb-4">

			<div class="item-template">
				<div class="template-img">
					<div class="temp-overlay"></div>
					<img class="img-fluid" src="{{$item->image}}" alt="{{$item->title}}">
				</div>
				<div class="template-offer">
					<div class="offer-text shadow-sm">{{$item->title}}</div>
					<a href="{{route('interfacepackage.web.detail',['slug'=>$item->slug])}}" title="{{$item->title}}" class="rounded-pill">{{trans('Langcore::global.Detail')}}</a>
				</div>
			</div>

		</div>
		@endforeach
	</div>
	<div class="text-center mt-5">
		<a href="{{route('interfacepackage.web.viewcat',['slug'=>$slug])}}" title="" class="btn btn-warning rounded-pill px-5">Xem thêm</a>
	</div>
</div>
@endif