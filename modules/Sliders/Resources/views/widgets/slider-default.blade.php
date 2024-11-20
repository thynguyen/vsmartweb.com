<div id="slider">
  <div class="slider-home owl-carousel owl-theme owl-loaded owl-drag">

    @foreach($sliders as $slider)
    <div class="item-slider-home">
      <div class="contet-slider d-flex align-items-center">
        <div class="img-slider">
          <img src="images/logowhite.png">
        </div>
        <div class="text-slider">
          <h3>{!!$slider->title!!}</h3>
          <span>{!!$slider->description!!}</span>
        </div>
      </div>
      <div class="bgimgslider" style="background-image: url({!!$slider->image!!});">
      </div>
    </div>
	@endforeach

  </div>
</div>