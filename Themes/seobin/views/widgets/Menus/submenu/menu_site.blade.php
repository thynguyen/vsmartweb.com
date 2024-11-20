<ul class="dropdown-menu tw-dropdown-menu">
	@foreach($listsubs as $key => $value)
	@php
	$href = ($value['urltype'] == 'route')? route($value['route']) : $value['url'];
	$icon = ($value['icon'])?'<i class="'.$value['icon'].' mr-2"></i>':'';
	@endphp
	<li>
		<a href="{!!$href!!}" title="{!!$value['title']!!}">{!!$icon.$value['title']!!}</a>
		{!!$value['submenu']!!}
	</li>
	@endforeach
</ul>