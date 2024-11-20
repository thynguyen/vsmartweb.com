@include('layouts.link')
@include('layouts.header')
<section id="content">
	<div class="container intra">
		@WidgetPlace('header')
		@yield('content')
		@WidgetPlace('bottom')
	</div>
</section>
@include('layouts.footer')
@include('layouts.script')