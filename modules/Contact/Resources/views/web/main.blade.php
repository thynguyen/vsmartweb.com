@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('Contact','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('module_contact_main')}}
@endsection
@section('header')
@if(env('MAP_DRIVER')=='mapbox' && env('MAPBOX_TOKEN'))
<link href='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.css' rel='stylesheet' />
<style type="text/css">
	#marker {
		width: 31px;
		height: 50px;
	}
	 
	.mapboxgl-popup {
		max-width: 200px;
	}
</style>
@endif
<style type="text/css">
	#map {
	    height: 400px;
	    width: 100%;
	}
</style>
@if(env('RECAPTCHA_SECRET_KEY') && env('RECAPTCHA_SITE_KEY'))
@if(env('RECAPTCHA_VERSION')=='v2')
{!! htmlScriptTagJsApi(['lang'=>LaravelLocalization::getCurrentLocale()]) !!}
@elseif(env('RECAPTCHA_VERSION')=='v3')
{!! htmlScriptTagJsApi(['action' => 'submitcontact']) !!}
@endif
@endif
@endsection
@section('content')
@include('layouts.flash-message')
<div class="row">
	<div class="col-sm-8">
		<div class="card">
			<div class="card-body">
				{!!Form::open(['method' => 'POST', 'route' => ['contact.web.submitcontact'], 'enctype'=> 'multipart/form-data'])!!}
					<div class="form-group">
						{!! Form::text('fullname', null, ['class' => 'form-control','id'=>'fullname','placeholder'=>trans('Langcore::global.FullName'),'required']) !!}
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							{!! Form::text('mobile', null, ['class' => 'form-control','id'=>'mobile','placeholder'=>trans('Langcore::global.Phone'),'required']) !!}
						</div>
						<div class="form-group col-md-6">
							{!! Form::text('email', null, ['class' => 'form-control','id'=>'email','placeholder'=>trans('Langcore::global.Email'),'required']) !!}
						</div>
					</div>
					@if($parts)
					<div class="form-group">
						{!!Form::select('partid', [''=>transmod('Contact::Parts')]+$parts, null, ['class' => 'form-control', 'id'=>'partid', 'tabindex' => '2', 'required'])!!}
					</div>
					@endif
					<div class="form-group">
						{!! Form::text('title', null, ['class' => 'form-control','id'=>'title','placeholder'=>trans('Langcore::global.Title'),'required']) !!}
					</div>
					<div class="form-group">
						{!! Form::textarea('messenger', null, ['class' => 'form-control','id'=>'messenger','rows'=>5,'placeholder'=>trans('Langcore::global.Content'),'required']) !!}
					</div>
					<div class="form-group">
						@CapchaSite()
						@if ($errors->has('g-recaptcha-response'))
                        <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
                        @endif
					</div>
					<button class="btn btn-sm btn-primary" type="submit">
						<i class="fas fa-dot-circle"></i> {{trans('Langcore::global.Save')}}
					</button>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="card mb-3">
			<div class="card-body">
				<address>
					{!!trans('Langcore::global.Address')!!}: {!!(CFglobal::cfn('site_address'))?CFglobal::cfn('site_address'):''!!}<br>
					{!!trans('Langcore::global.Phone')!!}: {!!(CFglobal::cfn('site_phone'))?CFglobal::cfn('site_phone'):''!!}<br>
					{!!trans('Langcore::global.Email')!!}: {!!(CFglobal::cfn('site_email'))?CFglobal::cfn('site_email'):''!!}<br>
				</address>
			</div>
		</div>
		@if((env('MAP_DRIVER')=='googlemap') && env('GOOGLE_MAP_KEY') || env('MAP_DRIVER')=='mapbox' && env('MAPBOX_TOKEN') && CFglobal::cfn('site_longitude') && CFglobal::cfn('site_latitude'))
		<div class="card">
			<div class="card-body h-100">
				<div id="map"></div>
			</div>
		</div>
		@endif
	</div>
</div>
@endsection
@section('footer')
@if((env('MAP_DRIVER')=='googlemap') && env('GOOGLE_MAP_KEY'))
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={!!env('GOOGLE_MAP_KEY')!!}" ></script>
	<script type="text/javascript" src="{{ asset('js/mapit/jquery.mapit.min.js') }}"></script>
	<script type="text/javascript">
		  $('#map').mapit({
		    latitude:    {!!CFglobal::cfn('site_latitude')!!},
		    longitude:   {!!CFglobal::cfn('site_longitude')!!},
		    zoom:        16,
		    type:        'ROADMAP',
		    scrollwheel: false,
		    marker: {
		      latitude:   {!!CFglobal::cfn('site_latitude')!!},
		      longitude:  {!!CFglobal::cfn('site_longitude')!!},
		      icon:       '{{ asset('images/marker_red.png') }}',
		      title:      '{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}',
		      open:       false,
		      center:     true
		    },
		    address: '<h5>{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}</h5><p>{!!trans('Langcore::global.Address')!!}: {!!(CFglobal::cfn('site_address'))?CFglobal::cfn('site_address'):''!!}</p><p>{!!trans('Langcore::global.Phone')!!}: {!!(CFglobal::cfn('site_phone'))?CFglobal::cfn('site_phone'):''!!}</p><p>{!!trans('Langcore::global.Email')!!}: {!!(CFglobal::cfn('site_email'))?CFglobal::cfn('site_email'):''!!}</p>',
		    styles: false,
		  });
	</script>
@elseif(env('MAP_DRIVER')=='mapbox' && env('MAPBOX_TOKEN') && CFglobal::cfn('site_longitude') && CFglobal::cfn('site_latitude'))
<script src='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.js'></script>
<script>
	mapboxgl.accessToken = '{!!env('MAPBOX_TOKEN')!!}';
	var monument = [{!!CFglobal::cfn('site_longitude')!!},{!!CFglobal::cfn('site_latitude')!!}];
	var map = new mapboxgl.Map({
		container: 'map',
		style: 'mapbox://styles/mapbox/streets-v11',
		center: monument,
		zoom: 13
	});
	 
	var popup = new mapboxgl.Popup({ offset: 25 })
	.setLngLat(monument)
	.setHTML('<h5>{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}</h5><p>{!!trans('Langcore::global.Address')!!}: {!!(CFglobal::cfn('site_address'))?CFglobal::cfn('site_address'):''!!}</p><p>{!!trans('Langcore::global.Phone')!!}: {!!(CFglobal::cfn('site_phone'))?CFglobal::cfn('site_phone'):''!!}</p><p>{!!trans('Langcore::global.Email')!!}: {!!(CFglobal::cfn('site_email'))?CFglobal::cfn('site_email'):''!!}</p>').addTo(map);

	var el = document.createElement('div');
	el.id = 'marker';

	var marker = new mapboxgl.Marker(el)
	.setLngLat(monument)
	.setPopup(popup)
	.addTo(map);

	marker.togglePopup();

	map.on('load', function() {
	map.loadImage(
		'{{ asset('images/marker_red.png') }}',
		function(error, image) {
			if (error) throw error;
			map.addImage('cat', image);
			map.addSource('point', {
				'type': 'geojson',
				'data': {
					'type': 'FeatureCollection',
					'features': [{
						'type': 'Feature',
						'geometry': {
							'type': 'Point',
							'coordinates': monument
						}
					}]
				}
			});
			map.addLayer({
				'id': 'points',
				'type': 'symbol',
				'source': 'point',
				'layout': {
					'icon-image': 'cat',
					'icon-size': 1
				}
			});
		});
	});
</script>
@endif
@endsection