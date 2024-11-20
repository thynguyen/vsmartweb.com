<div class="col-md-12 col-lg-6">
   <div class="footer-widget">
      <div class="section-heading">
         <h3>{{$widget['title']}}</h3>
         <span class="animate-border border-black"></span>
      </div>
      @if($widget['description'])
      <p>{{$widget['description']}}</p>
      @endif
      {!!$content!!}
   </div>
</div>