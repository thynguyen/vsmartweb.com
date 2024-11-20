function doAnimations(elems) {
  var animEndEv = "webkitAnimationEnd animationend";

  elems.each(function() {
    var $this = $(this),
      $animationType = $this.data("animation");
    $this.addClass($animationType).one(animEndEv, function() {
      $this.removeClass($animationType);
    });
  });
}

var $HomeSlider = $('.slider-home'),
  $firstAnimatingElems = $HomeSlider.find(".item-slider-home:first").find("[data-animation ^= 'animated']");
$HomeSlider.owlCarousel({
  lazyLoad : true,
  loop : true,
  dots : true,
  items : 1,
  margin : 10,
  autoHeight : true,
  autoplay : true,
  autoplayTimeout : 5000,
  autoplayHoverPause : true,
  // animateOut: 'flipInX',
});
doAnimations($firstAnimatingElems);
$HomeSlider.on("translate.owl.carousel", function(e) {
  var $animatingElems = $(this).find("[data-animation ^= 'animated']");
  doAnimations($animatingElems);
});