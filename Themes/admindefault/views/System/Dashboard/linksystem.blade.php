@if(Auth::check() && Auth::user()->in_group <= 2)
	@if(AdminFunc::AdminMenu('core/System'))
	<div class="row">
		@foreach(AdminFunc::AdminMenu('core/System') as $adsystemmenus)
			@foreach($adsystemmenus as $systemmenus)
			@if($systemmenus && AdminFunc::AdminPerMS($systemmenus['permission']))
			<div class="col-lg-2 col-sm-4 col-6 mb-3">
				<div class="card mb-0">
					<div class="card-body text-center">
						<a class="text-decoration-none" href="{{$systemmenus['route']}}" title="{!!$systemmenus['title']!!}">
							<div class="text-value-xl py-3 h1 text-muted">{!!$systemmenus['icon']!!}</div>
							<div class="text-muted small text-uppercase font-weight-bold">{!!$systemmenus['title']!!}</div>
						</a>
					</div>
				</div>
			</div>
			@endif
			@endforeach
		@endforeach
	</div>
	@endif
	<hr>
@endif