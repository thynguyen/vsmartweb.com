<div class="row justify-content-center">
   <div class="col-md-8 text-center">
      <div class="testimonial-slider owl-carousel">
         @foreach($testimonials as $testimonial)
         <div class="testimonial-content">
            <div class="testimonial-image">
               <img src="{!!$testimonial->avatar!!}" alt="{!!$testimonial->fullname!!}">
            </div>
            <div class="testimonial-meta">
               <h4>
                  {!!$testimonial->fullname!!}
                  <small>{!!$testimonial->address!!}</small>
               </h4>
               <i class="icon icon-quote2"></i>
            </div>
            <div class="testimonial-text">
               <p>{!!$testimonial->testimonial!!}</p>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</div>