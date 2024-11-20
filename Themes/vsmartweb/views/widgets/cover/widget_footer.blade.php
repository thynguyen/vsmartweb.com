<div class="col-sm-4">
   <div class="item-ft-widget">
      <h5 class="text-white fw-bold mb-4">{{$widget['title']}}</h5>
      @if($widget['description'])
      <p>{{$widget['description']}}</p>
      @endif
      {!!$content!!}
   </div>
</div>