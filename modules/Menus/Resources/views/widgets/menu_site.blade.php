<ul class="clearfix list-unstyled">
    @foreach($showmenu as $menu)
    @php
    $url = ($menu->urltype == 'route')? url($menu->route) : $menu->url;
    $route = ($menu->urltype == 'route')? $menu->route : '';
    @endphp
    <li class="{{ set_active($url) }}">
        <a href="{{$url}}" title="{{$menu->title}}">{{$menu->title}}</a>
        {!!$menu->submenu!!}
    </li>
    @endforeach
</ul>