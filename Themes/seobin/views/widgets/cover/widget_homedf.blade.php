<section{!!($widget['custom_id'])?' id="'.$widget['custom_id'].'"':'';!!}{!!($widget['custom_class'])?' class="'.$widget['custom_class'].'"':'';!!}>
   <div class="container">
      <div class="row text-center">
         <div class="col section-heading wow fadeInDown" data-wow-duration="1s" data-wow-delay=".5s">
            <h2>
               <small>{{$widget['description']}}</small>
               <span>{{$widget['title']}}</span>
            </h2>
            <span class="animate-border border-offwhite ml-auto mr-auto tw-mt-20"></span>
         </div>
      </div>
      {!!$content!!}
   </div>
</section>