<ul class="nav nav-tabs border-bottom-0 mt-5 d-flex justify-content-center owl-carousel owl-theme" id="templateTab">
	@foreach($category as $key => $cat)
	<li role="presentation">
		<button type="button" class="{{($key == 0)?'active':''}}" onclick="getlisttemp(this)" data-id="{{$cat->id}}" data-slug="{{$cat->slug}}">
			<i class="{{$cat->icon}}"></i>
			<span class="title-tabs-of">{{$cat->title}}</span>
		</button>
	</li>
	@endforeach
</ul>
<div class="padding80-0 bg-light" id="showlisttemplates"></div>