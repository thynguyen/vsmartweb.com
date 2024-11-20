<section{!!($widget['custom_id'])?' id="'.$widget['custom_id'].'"':'';!!}{!!($widget['custom_class'])?' class="'.$widget['custom_class'].'"':'';!!}>
   <div class="container">
      <div class="section-title text-center">
         <h2>{{$widget['title']}}</h2>
         <div class="section-desc">{{$widget['description']}}</div>
      </div>
   </div>
   {!!$content!!}
</section>