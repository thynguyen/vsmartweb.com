 <ul>
 	@foreach($showmenu as $menu)
	@php
	$url = ($menu->urltype == 'route')? url($menu->route) : $menu->url;
	$route = ($menu->urltype == 'route')? $menu->route : '';
	$icon = ($menu->icon)?'<i class="'.$menu->icon.' mr-2"></i>':'';
	@endphp
    <li><a href="{!!$url!!}" title="{{$menu->title}}">{!!$icon.$menu->title!!}</a></li>
    @endforeach
 </ul>