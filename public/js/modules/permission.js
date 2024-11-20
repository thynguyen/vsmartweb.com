function delpermission(a,b,c) {
    if (confirm(c) == true) {
        $.ajax({
            url: a,
            type: 'POST',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data: {
              _token: "<?php echo csrf_token(); ?>"
            },
            success: function(result) {
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
}
function addidmember(username){
    $('#adminname', opener.document).val(username);
    // $('#btselectuser', opener.document).text(username);
    window.close();
}