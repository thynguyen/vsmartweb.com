<section id="tw-client" class="tw-client">
  <div class="container">
     <div class="row  wow fadeInUp">
        <div class="col-md-12">
           <div class="clients-carousel owl-carousel">
              @foreach($sliders as $slider)
              <div class="client-logo-wrapper d-table">
                 <div class="client-logo d-table-cell">
                    <img src="{!!$slider->image!!}" alt="{!!$slider->title!!}" title="{!!$slider->title!!}">
                 </div>
              </div>
              @endforeach
           </div>
        </div>
     </div>
  </div>
</section>