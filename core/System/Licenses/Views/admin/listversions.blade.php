<div>
	<div class="d-flex justify-content-between mb-3">
		<div class="button">
			<button type="button" class="btn btn-sm btn-primary" onclick="addversion();">{!!trans('Langcore::licenses.AddVersion')!!}</button>
		</div>
		<div class="search rounded">
            {!! Form::text('searchversion', null, ['id'=>'searchversion','placeholder'=>trans('Langcore::global.Search'),'wire:model'=>'searchversion']) !!}
            <i class="fas fa-search"></i>
		</div>
	</div>
	<div class="accordion mb-3" id="listversions">
		@foreach($versions as $key => $version)
		<div class="card mb-0">
			<div class="card-header d-flex justify-content-between align-items-center py-1">
				<h5 class="mb-0">
					{{trans('Langcore::licenses.Version')}}: {{$version->version}}
					@if($version->current == 1)
					<i class="fad fa-bell-on" style="--fa-primary-color: limegreen; --fa-secondary-color: crimson; --fa-secondary-opacity: 1.0;"></i>
					@endif
				</h5>
				<button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#log{{$key}}" aria-expanded="true" aria-controls="log{{$key}}">
				{{trans('Langcore::licenses.ChangeLog')}}
				</button>
			</div>
			<div class="collapse" id="log{{$key}}" data-parent="#listversions">
				<div class="card-body p-0">
					<ul class="list-group list-group-flush">
						@if(!empty($version->changelog)&&$version->changelog!='null')
						@foreach(json_decode($version->changelog,true) as $key => $changelog)
						<li class="list-group-item py-2 d-flex align-items-center">
							<div class="bg-light rounded px-3 py-1 mr-2" style="width: 150px;">{!!$changelog['label']!!}</div> 
							<div>{!!$changelog['log']!!}</div>
						</li>
						@endforeach
						@endif
					</ul>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	{!!$paginator!!}
</div>