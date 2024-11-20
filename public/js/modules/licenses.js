function licenseregister(id){
	$('#formmodal').modal('show');
	modalcontent = $('#formmodal .modal-content');
	modalcontent.html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
	$.ajax({
		type : 'GET',
		url : route('licenses.admin.licenseregister',{id}),
		data : '',
		success : function(data) {
			modalcontent.html(data);
			if (id == null) {
				getcodelincense();
			}
	        $('#start_day').datetimepicker({
	            format:'Y/m/d',
	            onShow:function( ct ){
	                this.setOptions({
	                    maxDate:$('#expiration_date').val()?$('#expiration_date').val():false
	                })
	            },
	            timepicker:false,
	            mask:false,
	        });
	        $('#expiration_date').datetimepicker({
	            format:'Y/m/d',
	            onShow:function( ct ){
	                this.setOptions({
	                    minDate:$('#start_day').val()?$('#start_day').val():false
	                })
	            },
	            timepicker:false,
	            mask:false,
	        });
		}
	});
}
function getcodelincense(){
	$.ajax({
		type : 'POST',
		url : route('licenses.admin.getcodelincense'),
		data : {_token: csrf_token},
		success : function(data) {
			console.log(data);
			$('#license').val(data);
		}
	});
}

function changestatus(id){
	val = $('#status'+id).val();
	$.ajax({
		type : 'POST',
		url : route('licenses.admin.changestatus'),
		data : {_token: csrf_token,id:id,status:val},
		success : function(data) {
			console.log(data);
			new PNotify({
                title: "Done",
                text: data,
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
function dellicense(id){
	$.ajax({
		type : 'DELETE',
		url : route('licenses.admin.dellicense'),
		data : {
			_token: csrf_token,
			id:id
		},
		success : function(data) {
			$('#license'+id).remove();
			new PNotify({
                title: "Done",
                text: data,
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

function addversion(){
	$('#formmodal').modal('show');
	modalcontent = $('#formmodal .modal-content');
	modalcontent.html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
	$.ajax({
		type : 'GET',
		url : route('licenses.admin.addversion'),
		data : '',
		success : function(data) {
			modalcontent.html(data);
		}
	});
}

function pluschangelog(){
	numrow++;
	div = '<div class="changlog'+numrow+'">\
			<div class="form-group row">\
				<div class="col-sm-3">\
					<input class="form-control form-control" id="changloglabel'+numrow+'" name="changlog['+numrow+'][label]" type="text">\
				</div>\
				<div class="col-sm-7">\
					<input class="form-control form-control" id="changlog'+numrow+'" name="changlog['+numrow+'][log]" type="text">\
				</div>\
				<div class="col-sm-2">\
					<button type="button" class="btn btn-danger" onclick="delchangelog(\'changlog'+numrow+'\')"><i class="fal fa-trash-alt"></i></button>\
				</div>\
			</div>\
	    </div>';
	$('#listchangelog').append(div);
}
function delchangelog(idkey){
    $('.'+idkey).remove();
}