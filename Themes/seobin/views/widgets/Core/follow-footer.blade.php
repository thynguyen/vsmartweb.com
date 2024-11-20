<div class="footer-social-link">
   <h3>{!!trans('Langcore::global.FollowUs')!!}</h3>
   <ul>
      @foreach($follows as $follow)
      <li><a href="{!!$follow['link']!!}" title="{!!$follow['title']!!}" target="_black"><i class="{!!$follow['icon']!!}"></i></a></li>
      @endforeach
   </ul>
</div>