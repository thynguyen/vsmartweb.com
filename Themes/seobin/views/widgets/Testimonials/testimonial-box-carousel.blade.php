<div class="testimonial-box-carousel owl-carousel">
   @foreach($testimonials as $testimonial)
   <div class="tw-testimonial-box">
      <div class="testimonial-bg testimonial-bg-orange">
         <div class="testimonial-icon">
            <img src="{!!$testimonial->avatar!!}" alt="{!!$testimonial->fullname!!}" class="img-fluid">
         </div>
      </div>
      <div class="testimonial-meta">
         <h4>
            {!!$testimonial->fullname!!}
            <small>{!!$testimonial->address!!}</small>
         </h4>
      </div>
      <div class="testimonial-text">
         <p>{!!$testimonial->testimonial!!}</p>
         <i class="icon icon-quote2"></i>
      </div>
   </div>
   @endforeach
</div>