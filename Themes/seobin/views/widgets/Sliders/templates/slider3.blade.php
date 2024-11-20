<div class="slider-3">
   <div class="slider-arrow">
      <img src="{{ themes('images/slider/pattern_arrow2.png') }}" alt="sliderArrow1">
      <img src="{{ themes('images/slider/pattern_arrow1.png') }}" alt="sliderArrow2">
      <img src="{{ themes('images/slider/pattern_arrow3.png') }}" alt="sliderArrow3">
   </div>
   <div class="slider-wrapper d-table">
      <div class="slider-inner d-table-cell">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-md-6">
                  <img src="{!!$slider->image!!}" alt="{!!$slider->title!!}" class="img-fluid slider-img">
               </div>

               <div class="col-md-6">
                  <div class="slider-content">
                     <h2>{!!$slider->title!!}</h2>
                     <p>{!!$slider->description!!}</p>
                     <a href="{!!$slider->link!!}" title="{!!trans('Langcore::global.Detail')!!}" class="btn btn-dark">{!!trans('Langcore::global.Detail')!!}</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>