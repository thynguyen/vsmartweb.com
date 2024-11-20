<div class="px-2 py-1 mb-1 bg-light border">
	<div id="{{$loca}}" data-place="{{$loca}}" class="widgetgroup p-1">{{$placewidget}}</div>
	<button class="bg-dark w-100 border-0 text-white py-1 px-2 mb-1" type="button" data-toggle="modal" data-target="#medalwidget" onclick="loadaddwidget('{{ route('AddWidgetSite',['id'=>'null','placewidget'=>$loca]) }}')"><i class="fas fa-shapes"></i> <small>{{trans('Langcore::themes.AddWidget')}} [{{strtoupper($loca)}}]</small></button>
</div>