<section{!!($widget['custom_id'])?' id="'.$widget['custom_id'].'"':'';!!}{!!($widget['custom_class'])?' class="'.$widget['custom_class'].'"':'';!!}>
   <div class="container">
      <div class="text-white text-center row justify-content-md-center">
         <div class="col-lg-8">
            <h2 class="mb-4">{{$widget['title']}}</h2>
            <p class="fs-6 fw-bold mb-4">{{$widget['description']}}</p>
            {!!$content!!}
         </div>
      </div>
   </div>
</section>