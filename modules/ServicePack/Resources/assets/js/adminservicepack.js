function addservicepack(id){
    $('#formmodal').modal('show');
    $('#formmodal .modal-content').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
    $.ajax({
        type : 'GET',
        url : route('servicepack.admin.addservicepack',{id:id}),
        data : '',
        success : function(data) {
            $('#formmodal .modal-content').html(data);
            $('#contact').click(function(){
                if ($(this).prop('checked')) {
                    $('#priceservice').hide();
                } else {
                    $('#priceservice').show();
                }
            });
        }
    });
}

function plusoption(){
    numrow++;
    var div = '<div class="listoption'+numrow+'">\
        <div class="form-group row no-gutters">\
            <input class="form-control col-sm-10" id="listoption'+numrow+'" name="listoption['+numrow+']" type="text">\
            <div class="col-sm-2 text-center">\
                <button type="button" class="btn btn-danger" onclick="deleteoption(\'listoption'+numrow+'\')"><i class="fal fa-trash-alt"></i></button>\
            </div>\
        </div>\
    </div>';
    $('#listoptions').append(div);
}
function deleteoption(idkey){
    $('.'+idkey).remove();
}
function changepriceweight(id,newweight){
    var e = document.getElementById(newweight).options[document.getElementById(newweight).selectedIndex].value,d='#listitem';
    $.ajax({
        url: route('servicepack.admin.changeweight'),
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: csrf_token,
          id:id,
          newweight:e
        },
        success: function(result) {
            $( d ).load(window.location.href + " "+d+" > *");
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
function activeprice(e,id) {
    $(e).html('<i class="text-danger fas fa-spinner fa-spin fa-lg"></i>');
    $.ajax({
        url: route('servicepack.admin.activeprice'),
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data : {_token: csrf_token,id:id},
        success: function(result) {
            var b = '#servicepack'+id;
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
function delservicepack(id){
    if (confirm('Are you sure?') == true) {
        var d='#listitem';
        $.ajax({
            url: route('servicepack.admin.delservicepack'),
            type: 'DELETE',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data : {_token: csrf_token,id:id},
            success: function(result) {
                $( d ).load(window.location.href + " "+d+" > *");
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

function infouser(id){
    if ($('body').find('#infouser').length===0) {
        var div = '<div class="modal fade" id="infouser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">\
            <div class="modal-dialog modal-dialog-centered" role="document">\
                <div class="modal-content">\
                </div>\
            </div>\
        </div>';
        $('body').append(div);
    }
    $('#infouser').modal('show');
    $('#infouser .modal-content').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
    $.ajax({
        type : 'GET',
        url : route('servicepack.admin.infouser',{id:id}),
        data : '',
        success : function(data) {
            $('#infouser .modal-content').html(data);
        }
    });
}

function getlistmodulelimit(e){
    var id = $(e).val();
    $.ajax({
        type : 'POST',
        url : route('servicepack.admin.listmodulelimit'),
        data : {_token: csrf_token,id:id},
        success : function(data) {
            $('#listmodulelimit').html(data);
        }
    });
}