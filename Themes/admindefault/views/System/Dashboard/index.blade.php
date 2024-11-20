@extends('layouts.master')
@section('metatitle',trans('Langcore::global.dashboard'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_dashboard')}}
@endsection
@push('link')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous" />
@endpush
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success d-flex align-items-center" role="alert">
	<div class="avatar mr-2">
		<img src="@if(!empty(Auth::user()->avatar)) {{ Auth::user()->avatar }} @else {{ Avatar::create(Auth::user()->username)->toBase64() }} @endif" alt="{{ Auth::user()->username }}">
	</div>
	<span>
		{{trans('Langcore::global.welcome')}} <strong>{{Auth::user()->username}}</strong>!<br>
		{{trans('Langcore::global.AdminLoginBefore',['last_login'=> Auth::user()->last_login,'last_ip'=>Auth::user()->last_ip])}}
	</span>
</div>
@endif
@include('layouts.flash-message')
@include('System.Dashboard.linksystem')
@include('System.Dashboard.googleanalytics')
@endsection
@push('scripts')
	@if(env('ANALYTICS_VIEW_ID') && $fileanalyticsgg)
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
	<script type="text/javascript">
		var Visitors = new Chart($('#visitorsandpageview'), {
		  type: 'line',
		  data: {
		    labels: {!!$dates!!},
		    datasets: [{
				label: '{{trans('Langcore::global.PageViews')}}',
				backgroundColor: hexToRgba(getStyle('--info'), 10),
				borderColor: getStyle('--info'),
				pointHoverBackgroundColor: '#fff',
				borderWidth: 2,
				data: {!! json_encode($pageViews) !!}
		    }, {
				label: '{{trans('Langcore::global.Visits')}}',
				backgroundColor: 'transparent',
				borderColor: getStyle('--success'),
				pointHoverBackgroundColor: '#fff',
				borderWidth: 2,
				data: {!! json_encode($visitors) !!}
		    },]
		  },
		  options: {
		    responsive: true,
		    maintainAspectRatio: false,
		    legend: {
		      display: true,
		      position: 'bottom',
		    },
		    scales: {
		      xAxes: [{
		        gridLines: {
		          drawOnChartArea: false
		        }
		      }],
		      yAxes: [{
		        ticks: {
		          beginAtZero: true,
		          maxTicksLimit: 5,
		        }
		      }]
		    },
		    elements: {
		      point: {
		        radius: 0,
		        hitRadius: 10,
		        hoverRadius: 4,
		        hoverBorderWidth: 3
		      }
		    }
		  }
		});

		var Country = new Chart($('#country'), {
		  type: 'line',
		  data: {
		    labels: {!! json_encode($country) !!},
		    datasets: [{
				backgroundColor: 'rgba(255,255,255,.2)',
      			borderColor: 'rgba(255,255,255,.55)',
				data: {!! json_encode($country_sessions) !!}
		    }]
		  },
		    options: {
			    maintainAspectRatio: false,
			    legend: {
			      display: false
			    },
			    scales: {
			      xAxes: [{
			        display: false
			      }],
			      yAxes: [{
			        display: false
			      }]
			    },
			    elements: {
			      line: {
			        borderWidth: 2
			      },
			      point: {
			        radius: 0,
			        hitRadius: 10,
			        hoverRadius: 4
			      }
			    }
			  }
		});

		var Browsers = new Chart($('#topbrowsers'), {
		  type: 'bar',
		  data: {
		    labels: {!!json_encode($labels)!!},
		    datasets: [{
		      backgroundColor: 'rgba(255,255,255,.2)',
		      borderColor: 'rgba(255,255,255,.55)',
		      data: {!!json_encode($values)!!}
		    }]
		  },
		  options: {
		    maintainAspectRatio: false,
		    legend: {
		      display: false
		    },
		    scales: {
		      xAxes: [{
		        display: false,
		        barPercentage: 0.6
		      }],
		      yAxes: [{
		        display: false
		      }]
		    }
		  }
		});
		var Usertype = new Chart($('#usertype'), {
		  type: 'pie',
		  data: {
		    labels: {!!json_encode($usertype)!!},
		    datasets: [{
		      data: {!!json_encode($usersessions)!!},
		      backgroundColor: ['#FF6384', '#36A2EB'],
		      hoverBackgroundColor: ['#FF6384', '#36A2EB'],
		      weight: 20000
		    }]
		  },
		  options: {
		    responsive: true
		  }
		});
		var OperatingSystem = new Chart($('#operatingsystem'), {
		  type: 'line',
		  data: {
		    labels: {!!json_encode($operasystem)!!},
		    datasets: [{
		      backgroundColor: getStyle('--warning'),
		      borderColor: 'rgba(255,255,255,.55)',
		      data: {!!json_encode($operasysses)!!}
		    }]
		  },
		  options: {
		    maintainAspectRatio: false,
		    legend: {
		      display: false
		    },
		    scales: {
		      xAxes: [{
		        gridLines: {
		          color: 'transparent',
		          zeroLineColor: 'transparent'
		        },
		        ticks: {
		          fontSize: 2,
		          fontColor: 'transparent'
		        }
		      }],
		      yAxes: [{
		        display: false,
		        ticks: {
		          display: false,
		        }
		      }]
		    },
		    elements: {
		      line: {
		        tension: 0.00001,
		        borderWidth: 1
		      },
		      point: {
		        radius: 4,
		        hitRadius: 10,
		        hoverRadius: 4
		      }
		    }
		  }
		});
		var seslang = new Chart($('#seslang'), {
		  type: 'line',
		  data: {
		    labels: {!!json_encode($seslanguage)!!},
		    datasets: [{
		      backgroundColor: getStyle('--primary'),
		      borderColor: 'rgba(255,255,255,.55)',
		      data: {!!$langsessions!!}
		    }]
		  },
		  options: {
		    maintainAspectRatio: false,
		    legend: {
		      display: false
		    },
		    scales: {
		      xAxes: [{
		        gridLines: {
		          color: 'transparent',
		          zeroLineColor: 'transparent'
		        },
		        ticks: {
		          fontSize: 2,
		          fontColor: 'transparent'
		        }
		      }],
		      yAxes: [{
		        display: false,
		        ticks: {
		          display: false,
		        }
		      }]
		    },
		    elements: {
		      line: {
		        tension: 0.00001,
		        borderWidth: 1
		      },
		      point: {
		        radius: 4,
		        hitRadius: 10,
		        hoverRadius: 4
		      }
		    }
		  }
		});
	</script>
	@endif
@endpush