function addpart(id) {
	$('#formmodal').modal('show');
	$('#addpart').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
	$.ajax({
		type : 'GET',
		url : route('contact.admin.addpart',{id:id}),
		data : '',
		success : function(data) {
			$('#addpart').html(data);
		}
	});
}

function delpart(id) {
	$.ajax({
		type : 'POST',
		url : route('contact.admin.delpart'),
		data : {_token: csrf_token,id:id},
		success : function(data) {
			new PNotify({
                title: "Done",
                text: data,
                type: "success",
            });
            $('#part'+id).remove();
		}
	});
}

function addrecipients(){
	$('#addrecipients').modal('show');
	$('#formmodal').modal('hide');
	$('#addrecipients .modal-content').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
	var array = []; 
    $('#listrecipients').find('.userid').each(function() { 
        array.push($(this).val()); 
    });

	if (array===null) {
		$('#listrecipients').empty();
	}
	$.ajax({
		type : 'GET',
		url : route('contact.admin.listuser',[array]),
		data : '',
		success : function(data) {
			if (data == false) {
				$('#addrecipients').modal('hide');
				$('#formmodal').modal('show');
			} else {
				$('#addrecipients .modal-content').html(data);
			}
		}
	});
}
function getlistrecipients(){
	$('#addrecipients').modal('hide');
	$('#formmodal').modal('show');
    $("input:checkbox[name=usercheck]:checked").each(function() { 
        if ($('#listrecipients').find('.user'+$(this).val()).length == 0) {
	        name = $('.nameuser'+$(this).val()).text();
	        email = $('.emailuser'+$(this).val()).text();
	        div = '<tr class="user'+$(this).val()+'">\
	        <td><input name="recipients['+$(this).val()+'][userid]" type="hidden" class="userid" value="'+$(this).val()+'">'+name+'</td>\
	        <td>'+email+'</td>\
	        <td class="text-center"><input name="recipients['+$(this).val()+'][sendemail]" type="checkbox" value="1" checked></td>\
	        <td><button type="button" class="btn btn-sm btn-danger" onclick="delrecipient('+$(this).val()+')"><i class="fal fa-trash-alt"></i></button></td>\
	        </tr>';
	        $('#listrecipients').append(div);
	    }
    });
}
function delrecipient(userid){
	$('tr.user'+userid).remove();
	partid = $('.partid').val();
	if (partid.length > 0) {
		$.ajax({
			type : 'POST',
			url : route('contact.admin.delrecipient'),
			data : {_token: csrf_token,partid:partid,userid:userid},
			success : function(data) {
				if (data) {
					new PNotify({
		                title: "Done",
		                text: data,
		                type: "success",
		            });
				}
			}
		});
	}
}
function delcontact(id) {
	if (confirm('Are you sure?') == true) {
		$.ajax({
			type : 'POST',
			url : route('contact.admin.delcontact'),
			data : {_token: csrf_token,id:id},
			success : function(data) {
				new PNotify({
	                title: "Done",
	                text: data,
	                type: "success",
	            });
	            $('#contact'+id).remove();
			}
		});
	}
}