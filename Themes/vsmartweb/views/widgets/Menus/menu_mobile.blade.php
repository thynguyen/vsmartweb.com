<div class="menu-head">
   <div class="layer text-center">
      <img src="{{ !empty(CFglobal::cfn('site_logo')) ? CFglobal::cfn('site_logo') : themes('img/logo.png') }}" alt="{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):'';!!}" class="img-fluid"> 
   </div>
</div>
<nav class="menu-container">
   <ul class="menu-items">
      @foreach($showmenu as $menu)
      @php
      $url = ($menu->urltype == 'route')? url($menu->route) : $menu->url;
      $route = ($menu->urltype == 'route')? $menu->route : '';
      $icon = ($menu->icon)?'<i class="'.$menu->icon.' mr-2"></i>':'';
      @endphp
      <li {!!(count($menu->submenus)>0)?'class="has-sub"':''!!}>
         @if(count($menu->submenus)>0)
         <span class="dropdown-heading">{!!$icon.$menu->title!!}</span>
         @else
         <a href="{!!$url!!}" title="{{$menu->title}}">{!!$icon.$menu->title!!}</a>
         @endif
         {!!$menu->submenu!!}
      </li>
      @endforeach 
   </ul>
</nav>