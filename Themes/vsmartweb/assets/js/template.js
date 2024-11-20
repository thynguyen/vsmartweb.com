// $(".sidebar-dropdown > a").click(function () {
// 	$(".sidebar-submenu").slideUp(200);
// 	if ($(this).parent().hasClass("active")) {
// 		$(".sidebar-dropdown").removeClass("active");
// 		$(this).parent().removeClass("active");
// 	} else {
// 		$(".sidebar-dropdown").removeClass("active");
// 		$(this).next(".sidebar-submenu").slideDown(200);
// 		$(this).parent().addClass("active");
// 	}
// });
// $("#toggle-sidebar").click(function () {
// 	if ( $(this).find('i').is( ".fa-bars" ) ) {
// 		$(this).find('i').removeClass().addClass('fal fa-times fa-2x');
// 	} else {
// 		$(this).find('i').removeClass().addClass('fal fa-bars fa-2x');
// 	}
// 	$(".page-wrapper").toggleClass("toggled");
// });
$(".menu-container").jSideMenu({
	jSidePosition: "position-left",
	jSideSticky: true,
	jSideSkin: "default-skin",
});
$(document).ready(function() {
	$('body').append('<div id="toTop" class="btn"><i class="fal fa-chevron-up"></i></div>');
		$(window).scroll(function() {
			if ($(this).scrollTop() != 0) {
				$('#toTop').fadeIn();
			} else {
				$('#toTop').fadeOut();
			}

			var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
			bgheader = $('header').data('bghead');
			if (currentScroll < 300) {
				$('header').removeClass('position-fixed '+bgheader).addClass('position-absolute py-3');
			} else if(currentScroll > 300) {
				$('header').removeClass('position-absolute py-3').addClass('position-fixed '+bgheader);
			}
		});
		$('#toTop').click(function() {
			$("html, body").animate({scrollTop: 0}, 600);
		return false;
	});
});
new WOW().init();

var triggerTabList = [].slice.call(document.querySelectorAll('#templateTab a'))
triggerTabList.forEach(function (triggerEl) {
  var tabTrigger = new bootstrap.Tab(triggerEl)

  triggerEl.addEventListener('click', function (event) {
    event.preventDefault()
    tabTrigger.show()
  })
})
$("ul .nav-link").on("click", function(){
    $("ul .nav-item").each(function(i,e){
      $(e).find(".active").removeClass("active");
    });
    $(this).addClass('active');
});