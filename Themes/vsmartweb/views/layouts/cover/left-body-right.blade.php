<section id="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				@WidgetPlace('left')
			</div>
			<div class="col-sm-6">
				@WidgetPlace('header')
				@yield('content')
				@WidgetPlace('bottom')
			</div>			
			<div class="col-sm-3">
				@WidgetPlace('right')
			</div>
		</div>
	</div>
</section>