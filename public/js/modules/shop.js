function prodimgactive(a){
	$('input[type=checkbox].switch-input').removeClass('active').addClass('notactive').prop('checked', false);
	$('.valimgactive').val('0');
	$('#'+a).removeClass('notactive').addClass('active').prop('checked', true);
	$('#'+a+'val').val('1');
}