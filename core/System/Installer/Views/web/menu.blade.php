<ul class="nav flex-column">
  @foreach($menu as $m)
  <li class="nav-item{!!($number == $m['step'])?' active':''!!}">
	    <span class="step">
	      <span class="number rounded-circle{!!($m['step']<$number)?' bg-success':''!!}">{!!$m['step']!!}</span>
	      {!!$m['title']!!}
	    </span>
  </li>
  @endforeach
</ul>