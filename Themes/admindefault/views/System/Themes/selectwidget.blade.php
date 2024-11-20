<select name="widgetname" class="form-control" onchange="loadconfigwidget(this,'{{route('showconfigwidget')}}');">
	<option value="">--</option>
	@foreach($widgetmod as $modwidgets => $modwidget)
	<option value="{{$modwidget['widgetname']}}">{{$modwidget['widgetname']}}</option>
	@endforeach
</select>