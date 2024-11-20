<ul class="list-inline mb-0">
   @foreach($showmenu as $menu)
   @php
   $url = ($menu->urltype == 'route')? url($menu->route) : $menu->url;
   $route = ($menu->urltype == 'route')? $menu->route : '';
   $icon = ($menu->icon)?'<i class="'.$menu->icon.' mr-2"></i>':'';
   @endphp
   <li class="list-inline-item {{ set_active($url) }}">
      <a href="{!!$url!!}" title="{{$menu->title}}" class="text-decoration-none {!!(count($menu->submenus)>0)?'submenu-toggle':''!!}">{!!$icon.$menu->title!!}</a>
      {!!$menu->submenu!!}
   </li>
   @endforeach
</ul>