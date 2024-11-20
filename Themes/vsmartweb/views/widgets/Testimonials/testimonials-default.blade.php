<div class="container mt-5">
   <div class="list-testimonial owl-carousel owl-theme">
      @foreach($testimonials as $testimonial)
      <div class="testimonial-card">
         <div class="testimonial-info w-100">
            <div class="avatar border border-5 border-warning">
               <img src="{!!ThemesFunc::GetThumb($testimonial->avatar,150);!!}" alt="{!!$testimonial->fullname!!}">
            </div>
            <div class="w-100">
               <div class="name shadow">
                  <h4>{!!$testimonial->fullname!!}</h4>
                  <small>{!!$testimonial->address!!}</small>
               </div>
               <div class="testimonial-text">
                  {!!$testimonial->testimonial!!}
               </div>
            </div>
         </div>
      </div>
      @endforeach
   </div>
</div>