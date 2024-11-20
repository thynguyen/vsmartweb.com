@extends('layouts.master')
@section('metatitle',trans('Langcore::themes.ManagerWidget'))
@section('breadcrumbs')
{{Breadcrumbs::render('admin_widget_themes')}}
@endsection
@section('header')
	<link href="{{ themes('admindefault:css/modules/themes.css') }}" rel="stylesheet">
@endsection
@section('content')
@include('layouts.flash-message')
<div id="listwidget">
	<div class="row">
		<div class="col-sm-3">
			<div id="exampleAccordion" data-children=".item" class="accordion">
				@foreach($listallwg as $key => $module)
					@if($module['active'])
						@if($module['widget'])
						<div class="item card mb-0">
							<div class="card-header p-0" id="headingOne" role="tab"><a data-toggle="collapse" data-parent="#exampleAccordion" href="#modwidget{{$key}}" aria-expanded="false" aria-controls="modwidget{{$key}}" class="d-block px-3 text-dark font-weight-bold py-2">{{$module['module']}}</a></div>
							<div class="collapse" id="modwidget{{$key}}" role="tabpanel" style="">
								<ul class="list-group" id="accordion">
									@foreach($module['widget'] as $widget)
									<li class="list-group-item rounded-0 p-2">
										<div class="d-flex list-group-item-action justify-content-between align-items-center">
											{{$widget['name']}}
											<div class="btn-group" id="heading{{$widget['name']}}">
												<button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#medalwidget" onclick="loadaddwidget('{{ route('AddWidgetSite',['id'=>'null','placewidget'=>'null','mod'=>$module['path'],'widget'=>$widget['name']]) }}')">
												    <i class="fas fa-plus-square"></i>
												</button>
												@if($widget['desc'])
								                <button class="btn btn-sm btn-warning" type="button" data-toggle="collapse" data-target="#collapse{{$widget['name']}}" aria-expanded="true" aria-controls="collapse{{$widget['name']}}"><i class="fas fa-question"></i></button>
								                @endif
								            </div>
								        </div>
								        @if($widget['desc'])
							            <div class="collapse card card-body mt-1 mb-0" id="collapse{{$widget['name']}}" aria-labelledby="heading{{$widget['name']}}" data-parent="#accordion">
										    {{$widget['desc']}}
										</div>
										@endif
									</li>
									@endforeach
								</ul>
							</div>
						</div>
						@endif
					@endif
				@endforeach
			</div>
		</div>
		<div class="col-sm-9">
			<div class="row d-flex justify-content-end">
				@foreach($groupwidget as $key => $widgetgroup)

					<div class="col-sm-6">
						<div class="card card-body p-2">
							<h6 class="text-uppercase mb-1">{{$key}}</h6>
							<div id="{{$key}}" data-place="{{$key}}" class="widgetgroup p-1">
								@foreach($widgetgroup as $widget)
								<div id="{{$widget->id}}" class="d-flex justify-content-between border border-secondary rounded bg-light mb-1 p-2 item-widget">
									<div class="font-weight-bold align-self-center">{{$widget->title}}</div>
									<div class="d-flex justify-content-end">
										<div class="btn-group">
											<button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#medalwidget" onclick="loadaddwidget('{{ route('AddWidgetSite',['id'=>$widget->id]) }}')">
						                        <i class="fas fa-edit"></i>
						                    </button>
						                    <button class="btn btn-sm btn-danger active" onclick="deletesys('{{ route('deletewidget',['id'=>$widget->id,'widgetgroup'=>$widget->widgetgroup]) }}','#listwidget','','{{trans('Langcore::global.warning_delfile')}}')" type="button" aria-pressed="true"><i class="fas fa-trash-alt"></i></button>
						                </div>
					                </div>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection
@section('footer')
<div class="modal fade" id="medalwidget" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="showaddwidget"></div>
	</div>
</div>
<script type="text/javascript">
	DrapNDrop('.widgetgroup','{{route('changelistwidgetaj')}}',$(this).data("place"));
	$('[data-toggle="popover"]').popover();
</script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
@endsection