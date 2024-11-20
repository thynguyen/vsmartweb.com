function showservicepack(){
	var servicepack = $('#servicepackcode').val();
	// console.log(servicepack);
	var expiredat = $('#expiredat').val();
	$('#showservicepack').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
	$.ajax({
        type : 'POST',
        url : route('servicepack.web.getservicepack'),
        data : {
        	_token: csrf_token,
        	servicepack:servicepack,
        	expiredat:expiredat
        },
        success : function(data) {
            $('#showservicepack').html(data);
        }
    });
}
function showpaymentcycle(){
	var price = $('span.getpriceservvice').data('price');
	var expiredat = $('#expiredat').val();
	$('.total-price').html('<i class="fas fa-spinner fa-spin"></i>');
	$('.showpaymentcycle').html('<i class="fas fa-spinner fa-spin"></i>');
	setTimeout(function() {
		var total = formatmoney(parseInt(price, 10)*parseInt(expiredat, 10),',');
		var numyear = expiredat/12;
		var paymentcycle = (numyear >= 1)?numyear+' '+Year:expiredat+' '+Month;
		$('.total-price').html(total+unimoney);
		$('.showpaymentcycle').html(paymentcycle);
	}, 300);
}
function formatmoney(total,type){
	return String(total).replace(/(.)(?=(\d{3})+$)/g,'$1'+type);
}