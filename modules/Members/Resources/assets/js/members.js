function passwordStrength(password) {
	var msg = ['not acceptable', 'very weak', 'weak', 'standard', 'looks good', 'yeahhh, strong mate.'];
	var desc = ['0%', '20%', '40%', '60%', '80%', '100%'];
	var descClass = ['', 'bg-danger', 'bg-danger', 'bg-warning', 'bg-success', 'bg-success'];
	var score = 0;
	if (password.length > 6) score++;
	if ((password.match(/[a-z]/)) && (password.match(/[A-Z]/))) score++;
	if (password.match(/\d+/)) score++;
	if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;
	if (password.length > 10) score++;
	$(".jak_pstrength").removeClass(descClass[score-1]).addClass(descClass[score]).css( "width", desc[score] ).html(msg[score]);
    console.log(desc[score]);
}
function passwordConfirm(passwordcf){
	var password = $('#password').val();
	if(passwordcf === password){
		$('.text-confirm').html('<span class="badge badge-success">Good</span>');
	} else {
		$('.text-confirm').html('<span class="badge badge-danger">Passwords do not match.</span>');
	}
}