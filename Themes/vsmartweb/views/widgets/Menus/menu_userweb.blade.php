<ul class="navbar-nav mr-auto">
   @foreach($showmenu as $menu)
   @php
   $url = ($menu->urltype == 'route')? url($menu->route) : $menu->url;
   $route = ($menu->urltype == 'route')? $menu->route : '';
   $icon = ($menu->icon)?'<i class="'.$menu->icon.' mr-2"></i>':'';
   @endphp
   <li class="nav-item {{ set_active($url) }}">
      <a href="{!!$url!!}" title="{{$menu->title}}" class="nav-link py-lg-4 px-3">{!!$icon.$menu->title!!}</a>
      {!!$menu->submenu!!}
   </li>
   @endforeach
</ul>
   