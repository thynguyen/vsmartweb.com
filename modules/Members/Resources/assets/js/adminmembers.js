function activemem(id) {
	$.ajax({
        url: route('members.admin.activemem'),
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data : {_token: csrf_token,id:id},
        success: function(result) {
            var b = '#member'+id;
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

function delmem(id){
    if (confirm('Are You Sure?') == true) {
        $.ajax({
            url: route('members.admin.deluser'),
            type: 'POST',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data : {_token: csrf_token,id:id},
            success: function(result) {
                var b = '#member'+id;
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
                    title: "Error",
                    text: err,
                    type: "warning"
                });
            }
        });
    }
}