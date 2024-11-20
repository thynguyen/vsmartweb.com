<ul class="navbar-nav">
   @foreach($showmenu as $menu)
   @php
   $url = ($menu->urltype == 'route')? url($menu->route) : $menu->url;
   $route = ($menu->urltype == 'route')? $menu->route : '';
   $icon = ($menu->icon)?'<i class="'.$menu->icon.' mr-2"></i>':'';
   @endphp
   <li class="nav-item {!!(count($menu->submenus)>0)?'dropdown':''!!} {{ set_active($url) }}">
      <a class="nav-link" href="{!!$url!!}" title="{{$menu->title}}" {!!(count($menu->submenus)>0)?'data-toggle="dropdown"':''!!}>
         {!!$icon.$menu->title!!}
         @if(count($menu->submenus)>0)
         <span class="tw-indicator"><i class="far fa-angle-down"></i></span>
         @endif
      </a>
      {!!$menu->submenu!!}
   </li>
   @endforeach
</ul>