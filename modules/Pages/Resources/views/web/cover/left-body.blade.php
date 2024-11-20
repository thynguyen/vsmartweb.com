@include('layouts.link')
@include('layouts.header')
<section id="content">
	<div class="container intra">
		<div class="row">
			<div class="col-lg-9 order-lg-2">
				@WidgetPlace('header')
				@yield('content')
				@WidgetPlace('bottom')
			</div>
			<div class="col-lg-3 order-lg-1">
				@WidgetPlace('left')
			</div>
		</div>
	</div>
</section>
@include('layouts.footer')
@include('layouts.script')