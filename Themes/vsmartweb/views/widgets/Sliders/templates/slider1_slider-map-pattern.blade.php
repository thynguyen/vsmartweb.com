<div class="slider-1 slider-map-pattern">
   <div class="slider-wrapper d-table">
      <div class="slider-inner d-table-cell">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-md-12">
                  <img src="{!!$slider->image!!}" alt="{!!$slider->title!!}" class="slider-img img-fluid">
               </div>
            </div>
            <div class="row justify-content-center text-center">
               <div class="col-md-10">
                  <h2 class="tw-slider-subtitle">{!!$slider->description!!}</h2>
                  <h4 class="tw-slider-title">{!!$slider->title!!}
                  </h4>
                  <a href="{!!$slider->link!!}" title="{!!trans('Langcore::global.Detail')!!}" class="btn btn-primary">{!!trans('Langcore::global.Detail')!!}</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>