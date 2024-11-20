<section{!!($widget['custom_id'])?' id="'.$widget['custom_id'].'"':'';!!}{!!($widget['custom_class'])?' class="'.$widget['custom_class'].'"':'';!!}>
   <div class="container">
      <div class="row tw-mb-65">
         <div class="col-md-4 wow fadeInLeft" data-wow-duration="1s">
            <h2 class="column-title text-md-right text-sm-center">{{$widget['title']}}</h2>
         </div>
         <div class="col-md-7 ml-md-auto wow fadeInRight" data-wow-duration="1s">
            <p class="features-text">{{$widget['description']}}</p>
         </div>
      </div>
      {!!$content!!}
   </div>
</section>