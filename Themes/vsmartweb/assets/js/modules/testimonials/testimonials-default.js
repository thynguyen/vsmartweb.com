$('.list-testimonial').owlCarousel({
   loop:true,
   dots:true,
   nav:false,
   autoplay:true,
   autoplayTimeout:3000,
   autoplayHoverPause:true,
   lazyLoad:true,
   lazyLoadEager:2,
   margin:50,
   responsive:{
      0:{
         items:1
      },
      1000:{
         items:2
      }
   }
});