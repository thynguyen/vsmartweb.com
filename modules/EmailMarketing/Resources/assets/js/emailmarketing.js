function newslettersubscribe(){
	$('.newsletter_notyfi').show('slow').html('<div class="spinner-border spinner-border-sm text-warning" role="status"><span class="sr-only">Loading...</span></div>');
	email = $('#email_subscribe');
	$.ajax({
        type:"POST",
        url: route('emailmarketing.web.subscribe'),
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: csrf_token,
          email:email.val()
        },
        success: function(result) {
        	email.val(null);
            $('.newsletter_notyfi').html(result);
            setTimeout(function() {
            	$('.newsletter_notyfi').hide().empty();
            }, 5000);
        },
    })
}