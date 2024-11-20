function addcategory(id) {
    $('#formmodal').modal('show');
    $('#formmodal .modal-content').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
    $.ajax({
        type : 'GET',
        url : route('news.admin.addcategory',{id:id}),
        data : '',
        success : function(data) {
            $('#formmodal .modal-content').html(data);
        }
    });
}
function delcategory(id){
    if (confirm(configdelcat) == true) {
        $.ajax({
            url: route('news.admin.delcategory'),
            type: 'DELETE',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data : {_token: csrf_token,id:id},
            success: function(result) {
                var b = '#cat'+id;
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
function changeweightcategory(id,parentid,a,b) {
    var newweight = $('#'+a).val();
    $.ajax({
        url: route('news.admin.changeweightcat'),
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: csrf_token,
          id:id,
          parentid:parentid,
          newweight:newweight
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
function checktitleslug(title,slug){
    spinner = '<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>';
    $.ajax({
        type : 'POST',
        url : route('news.admin.checktitleslug'),
        data:{
            _token: csrf_token,
            title:title,
            slug:slug
        },
        beforeSend: function(){
            $('button[type="submit"]').prop('disabled', true).removeClass('btn-primary').addClass('btn-secondary');
            $('.error-title').html(spinner);
            $('.error-slug').html(spinner);
        },
        success:function(data){
            $('.error-title').html(data.title.msg);
            $('.error-slug').html(data.slug.msg);
            if (data.title.check != 1 || data.slug.check != 1) {
                $('button[type="submit"]').prop('disabled', false).removeClass('btn-secondary').addClass('btn-primary');
            }
        }
    });
}
function activenew(id){
    $.ajax({
        type : 'POST',
        url : route('news.admin.activenew'),
        data:{
            _token: csrf_token,
            id:id
        },
        success: function(result) {
            var b = '#new'+id;
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
function deletenew(id){
    if (confirm(configdelnew) == true) {
        $.ajax({
            type : 'DELETE',
            url : route('news.admin.delnew'),
            data:{
                _token: csrf_token,
                id:id
            },
            success: function(result) {
                var b = '#new'+id;
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