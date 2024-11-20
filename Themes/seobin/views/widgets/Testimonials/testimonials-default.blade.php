<div class="row align-items-center justify-content-center">
   <div class="col-md-6 wow fadeInLeft" data-wow-duration="1s">
      <div class="tw-testimonial-carousel owl-carousel">
         @foreach($testimonials as $testimonial)
         <div class="tw-testimonial-wrapper">
            <div class="testimonial-bg testimonial-bg-orange">
               <div class="testimonial-icon">
                  <img src="{!!$testimonial->avatar!!}" alt="{!!$testimonial->fullname!!}" class="img-fluid">
               </div>
            </div>
            <div class="testimonial-text">
               <p>{!!$testimonial->testimonial!!}</p>
               <div class="testimonial-meta">
                  <h4>
                     {!!$testimonial->fullname!!}
                     <small>{!!$testimonial->address!!}</small>
                  </h4>
                  <i class="icon icon-quote2"></i>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</div>
               