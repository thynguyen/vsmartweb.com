<div class="top-social-links">
  <span>{!!trans('Langcore::global.FollowUs')!!}:</span>
  @foreach($follows as $follow)
  <a href="{!!$follow['link']!!}" title="{!!$follow['title']!!}" target="_black"><i class="{!!$follow['icon']!!}"></i></a>
  @endforeach
</div>