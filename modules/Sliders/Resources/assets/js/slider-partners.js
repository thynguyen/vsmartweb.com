$('.listpartners').owlCarousel({
  loop:true,
  margin:40,
  nav:false,
  navText: ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
  dots:false,
  autoplay:true,
  autoplayTimeout:3000,
  autoplayHoverPause:true,
  responsiveClass:true,
  responsive:{
    0:{
      items:2
    },
    600:{
      items:4
    },
    1000:{
      items:5
    }
  }
});