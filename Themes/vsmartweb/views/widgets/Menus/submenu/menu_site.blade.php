<ul class="list-inline mb-0 rounded">
	@foreach($listsubs as $key => $value)
	@php
	$href = ($value->urltype == 'route')? url($value->route) : $value->url;
	$icon = ($value['icon'])?'<i class="'.$value['icon'].' mr-2"></i>':'';
	@endphp
	<li>
		<a href="{!!$href!!}" title="{!!$value['title']!!}" class="text-decoration-none">{!!$icon.$value['title']!!}</a>
		{!!$value['submenu']!!}
	</li>
	@endforeach
</ul>