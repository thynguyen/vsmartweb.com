getlisttemp();
$('#templateTab').owlCarousel({
	dots:false,
	nav:false,
	margin:0,
	responsiveClass:true,
    autoWidth:true,
	navText:['<i class="fal fa-chevron-left fa-lg"></i>','<i class="fal fa-chevron-right fa-lg"></i>'],
	responsive:{
		0:{
		   items:3
		},
		600:{
		   items:4
		},
		1000:{
		   items:5
		}
	}
});
function getlisttemp(event){
	if (event) {
		$('#typical-template li button').removeClass('active');
		$(event).addClass('active');
	}
	var e = $('#typical-template li').find('button.active');
	var id = $(e).data('id');
	var slug = $(e).data('slug') ;
	console.log(id+'-'+slug);
	$('#showlisttemplates').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
	$.ajax({
		type: 'GET',
		url: route('interfacepackage.web.getitemtempcat',{id:id,slug:slug}),
		data:'',
		success:function(data){
			$('#showlisttemplates').html(data);
		}
	});
}
