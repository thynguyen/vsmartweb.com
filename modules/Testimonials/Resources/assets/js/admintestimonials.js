function addtestimonial(id){
    $('#formmodal').modal('show');
    $('#formmodal .modal-content').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
    $.ajax({
        type : 'GET',
        url : route('testimonials.admin.addtestimonial',{id:id}),
        data : '',
        success : function(data) {
            $('#formmodal .modal-content').html(data);
        }
    });
}
function activetestimonial(id) {
	$.ajax({
        url: route('testimonials.admin.activetestimonial'),
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data : {_token: csrf_token,id:id},
        success: function(result) {
            var b = 'tbody';
        	$( b ).load(window.location.href + " "+b+" > *");
            new PNotify({
                title: "Done",
                text: result,
                type: "success",
            });
        },
        error: function(result, status, error) {
            var err = JSON.parse(result.responseText);
            new PNotify({
                title: "Error",
                text: err,
                type: "warning"
            });
        }
    });
}
function deltestimonial(id){
    if (confirm(configdeltestimonial) == true) {
        $.ajax({
            url: route('testimonials.admin.deltestimonial'),
            type: 'DELETE',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data : {_token: csrf_token,id:id},
            success: function(result) {
                var b = '#testimonial'+id;
                $( b ).remove();
                new PNotify({
                    title: "Done",
                    text: result,
                    type: "success",
                });
            },
            error: function(result, status, error) {
                var err = JSON.parse(result.responseText);
                new PNotify({
                    title: "Warning",
                    text: err,
                    type: "warning"
                });
            }
        });
    }
}