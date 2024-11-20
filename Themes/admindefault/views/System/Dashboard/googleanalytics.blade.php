@if(!$fileanalyticsgg && env('ANALYTICS_VIEW_ID'))
<div class="alert alert-warning d-flex align-items-center" role="alert">
	{{trans('Langcore::global.NoFileFoundGGAnalytics')}}
</div>
@endif
@if(env('ANALYTICS_VIEW_ID') && $fileanalyticsgg)
<div class="row">
	<div class="col-sm-6 col-lg-3">
		<div class="card text-white bg-primary">
			<div class="card-body pb-0">
				<button class="btn btn-transparent p-0 float-right" type="button">
                  <i class="fas fa-globe-asia"></i> {{trans('Langcore::language.Language')}}
                </button>
				<div class="text-value">
					{!!$countLang!!}
				</div>
				<div>
					{{trans('Langcore::global.Visits')}}
				</div>
			</div>
			<div class="chart-wrapper mt-3 mx-3" style="height:70px;">
				<canvas class="chart" id="seslang" height="70"></canvas>					
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-lg-3">
		<div class="card text-white bg-info">
			<div class="card-body pb-0">
				<button class="btn btn-transparent p-0 float-right" type="button">
                  <i class="icon-location-pin"></i> {{trans('Langcore::global.Country')}}
                </button>
				<div class="text-value">
					{!!$countSes!!}
				</div>
				<div>
					{{trans('Langcore::global.Visits')}}
				</div>
			</div>
			<div class="chart-wrapper mt-3 mx-3" style="height:70px;">
				<canvas id="country" class="chart" height="70"></canvas>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-lg-3">
		<div class="card text-white bg-warning">
			<div class="card-body pb-0">
				<button class="btn btn-transparent p-0 float-right" type="button">
					<i class="fas fa-laptop"></i> {{trans('Langcore::global.OperatingSystem')}}
				</button>
				<div class="text-value">
					{!!$countOSys!!}
				</div>
				<div>
					{{trans('Langcore::global.Visits')}}
				</div>
			</div>
			<div class="chart-wrapper mt-3 mx-3" style="height:70px;">
				<canvas class="chart" id="operatingsystem" height="70"></canvas>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-lg-3">
		<div class="card text-white bg-danger">
			<div class="card-body pb-0">
				<button class="btn btn-transparent p-0 float-right" type="button">
                  <i class="fab fa-chrome"></i> {{trans('Langcore::global.Browser')}}
                </button>
				<div class="text-value">
					{!!$countVal!!}
				</div>
				<div>
					{{trans('Langcore::global.Visits')}}
				</div>
			</div>
			<div class="chart-wrapper mt-3 mx-3" style="height:70px;">
				<canvas id="topbrowsers" class="chart" height="70"></canvas>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<div class="clearfix mb-3 pb-2 border-bottom">
			<div class="row">
				<div class="col-sm-7">
					<canvas id="visitorsandpageview" height="250"></canvas>
				</div>
				<div class="col-sm-5">
					<canvas id="usertype"></canvas>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3 d-flex align-items-center my-2">
				<i class="far fa-eye bg-primary p-3 font-2xl mr-3"></i>
				<div>
					<div class="text-value-sm text-primary">
						{{$generalAnalytics['sessions']}}
					</div>
					<div class="text-muted text-uppercase font-weight-bold small">
						{{trans('Langcore::global.Sessions')}}
					</div>
				</div>
			</div>
			<div class="col-sm-3 d-flex align-items-center my-2">
				<i class="fas fa-users bg-warning p-3 font-2xl mr-3"></i>
				<div>
					<div class="text-value-sm text-warning">
						{{$generalAnalytics['users']}}
					</div>
					<div class="text-muted text-uppercase font-weight-bold small">
						{{trans('Langcore::global.Visitor')}}
					</div>
				</div>
			</div>
			<div class="col-sm-3 d-flex align-items-center my-2">
				<i class="fas fa-chalkboard-teacher bg-success p-3 font-2xl mr-3"></i>
				<div>
					<div class="text-value-sm text-success">
						{{$generalAnalytics['pageviews']}}
					</div>
					<div class="text-muted text-uppercase font-weight-bold small">
						{{trans('Langcore::global.PageViews')}}
					</div>
				</div>
			</div>
			<div class="col-sm-3 d-flex align-items-center my-2">
				<i class="fas fa-door-open bg-secondary p-3 font-2xl mr-3"></i>
				<div>
					<div class="text-value-sm text-secondary">
						{{$generalAnalytics['bounceRate']}}%
					</div>
					<div class="text-muted text-uppercase font-weight-bold small">
						{{trans('Langcore::global.BounceRate')}}
					</div>
				</div>
			</div>
			<div class="col-sm-3 d-flex align-items-center my-2">
				<i class="fas fa-chart-line bg-success p-3 font-2xl mr-3"></i>
				<div>
					<div class="text-value-sm text-success">
						{{$generalAnalytics['pageviewsPerSession']}}
					</div>
					<div class="text-muted text-uppercase font-weight-bold small">
						{{trans('Langcore::global.PagesDivisionSession')}}
					</div>
				</div>
			</div>
			<div class="col-sm-3 d-flex align-items-center my-2">
				<i class="fas fa-history bg-danger p-3 font-2xl mr-3"></i>
				<div>
					<div class="text-value-sm text-danger">
						{{$generalAnalytics['avgSessionDuration']}}
					</div>
					<div class="text-muted text-uppercase font-weight-bold small">
						{{trans('Langcore::global.AverageTime')}}
					</div>
				</div>
			</div>
			<div class="col-sm-3 d-flex align-items-center my-2">
				<i class="fas fa-child bg-primary p-3 font-2xl mr-3"></i>
				<div>
					<div class="text-value-sm text-primary">
						{{$generalAnalytics['newUsers']}}
					</div>
					<div class="text-muted text-uppercase font-weight-bold small">
						{{trans('Langcore::global.NewVisitors')}}
					</div>
				</div>
			</div>
			<div class="col-sm-3 d-flex align-items-center my-2">
				<i class="fas fa-podcast bg-warning p-3 font-2xl mr-3"></i>
				<div>
					<div class="text-value-sm text-warning">
						{{$generalAnalytics['sessionsPerUser']}}
					</div>
					<div class="text-muted text-uppercase font-weight-bold small">
						{{trans('Langcore::global.SessionsDivisionUsers')}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">
				{{trans('Langcore::global.TopContent')}}
			</div>
			<div class="card-body p-0">
				<table class="table table-responsive-sm table-sm table-striped">
					<thead>
						<tr>
							<th>{{trans('Langcore::global.NumericalOrder')}}</th>
							<th>{{trans('Langcore::global.Posts')}}</th>
							<th width="80">{{trans('Langcore::global.PageViews')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($visitpages as $key => $vspage)
						<tr>
							<td align="center">{{$key + 1}}</td>
							<td><a href="{{$http.$vspage['url']}}" title="{{$vspage['pageTitle']}}" target="_black">{{$vspage['pageTitle']}}</a></td>
							<td align="center">{{$vspage['pageViews']}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>					
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="card">
			<div class="card-header">
				{{trans('Langcore::global.TopIntroduction')}}
			</div>
			<div class="card-body  p-0">
				<table class="table table-responsive-sm table-sm table-striped">
					<thead>
						<tr>
							<th>{{trans('Langcore::global.NumericalOrder')}}</th>
							<th>{{trans('Langcore::global.Source')}}</th>
							<th>{{trans('Langcore::global.PageViews')}}</th>
							<!-- <th>{{trans('Langcore::global.AverageTime')}}</th> -->
						</tr>
					</thead>
					<tbody>
						@foreach($traffics as $key => $traff)
						<tr>
							<td align="center">{{$key + 1}}</td>
							<td>{{$traff['source'].'/'.$traff['medium']}}</td>
							<td align="center">{{$traff['pageviews']}}</td>
							<!-- <td align="center">{{$traff['sessionduration']}}</td> -->
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endif