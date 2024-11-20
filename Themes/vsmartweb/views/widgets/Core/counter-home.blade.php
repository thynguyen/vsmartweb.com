<section id="tw-facts" class="tw-facts">
   <div class="facts-bg-pattern d-none d-lg-block">
      <img class="wow fadeInLeft" src="{{themes('images/funfacts/arrow_left.png')}}" alt="arrwo_left">
      <img class="wow fadeInRight" src="{{themes('images/funfacts/arrow_right.png')}}" alt="arrow_right">
   </div>
   <div class="container">
      <div class="row">
         @foreach($counters as $counter)
         <div class="col-md-3 text-center">
            <div class="tw-facts-box">
               <div class="facts-img wow zoomIn" data-wow-duration="1s">
                  <span class="fa-3x" style="--fa-primary-color: orange; --fa-secondary-color: black;">{!!$counter['icon']!!}</span>
               </div>
               <div class="facts-content wow fadeInUp" data-wow-duration="1s">
                  <h4 class="facts-title">{!!$counter['title']!!}</h4>
                  <span class="counter">{!!$counter['number']!!}</span>
                  <sup>{!!$counter['subnum']!!}</sup>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</section>
 