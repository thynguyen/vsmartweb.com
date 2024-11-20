function addgroup(id) {
	$('#formmodal').modal('show');
	$('#addgroup').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
	$.ajax({
		type : 'GET',
		url : route('sliders.admin.addgroup',{id:id}),
		data : '',
		success : function(data) {
			$('#addgroup').html(data);
		}
	});
}
function delgroup(id) {
	$.ajax({
		type : 'POST',
		url : route('sliders.admin.delgroup'),
		data : {_token: csrf_token,id:id},
		success : function(data) {
			new PNotify({
                title: "Done",
                text: data,
                type: "success",
            });
			b = '.list-group';
			$( b ).load(window.location.href + " "+b+" > *");
		}
	});
}
function delslider(id,groupid) {
	$.ajax({
		type : 'POST',
		url : route('sliders.admin.delslider'),
		data : {_token: csrf_token,id:id,groupid:groupid},
		success : function(data) {
			a = 'tbody';
			$( a ).load(window.location.href + " "+a+" > *");
			loadlistslider(groupid);
			new PNotify({
                title: "Done",
                text: data,
                type: "success",
            });
		}
	});
}

function loadlistslider(id){
	$('#listsliders .card-body').append('<div id="maskpin"><div class="loading rounded"><i class="fas fa-spinner fa-spin mr-1"></i> Loading</div><div class="maskbg rounded"></div></div>');
	$.ajax({
		type : 'GET',
		url : route('sliders.admin.listsliders',{groupid:id}),
		data : '',
		success : function(data) {
			$('#listsliders').html(data);
		}
	});
}
function addslider(groupid,id) {
	$('#formmodal').modal('show');
	$('#addgroup').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
	$.ajax({
		type : 'GET',
		url : route('sliders.admin.addslider',[groupid,id]),
		data : '',
		success : function(data) {
			$('#addgroup').html(data);
		}
	});
}

function submitaddslider(groupid,id){
	title = $('#title').val();
	description = $('#description').val();
	link = $('#link').val();
	image = $('#image').val();
	custom_id =  $('#custom_id').val();
	custom_class =  $('#custom_class').val();
	template = $('#template').val();
	groupid = (groupid !== 'null')?groupid:'';
	id = (id !== 'null')?id:'';
	if (image) {
		$.ajax({
			type : 'POST',
			url : route('sliders.admin.submitaddslider'),
			data : {
				_token: csrf_token,
				groupid:groupid,
				id:id,
				title:title,
				description:description,
				link:link,
				custom_id:custom_id,
				custom_class:custom_class,
				image:image,
				template:template
			},
			success : function(data) {
				$('#formmodal').modal('hide');
				b = '.table';
				$( b ).load(window.location.href + " "+b+" > *");
				loadlistslider(groupid);
				new PNotify({
	                title: "Done",
	                text: data.msg,
	                type: "success",
	            });
			}
		});
	} else {
		new PNotify({
            title: "warning",
            text: 'No photo of the Slider',
            type: "warning",
        });
	}
}

function changesliderweight(a,b,c) {
    var e = document.getElementById(c).options[document.getElementById(c).selectedIndex].value,d='tbody';
    $.ajax({
        url: route('sliders.admin.changeweight'),
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: csrf_token,
          id:a,
          groupid:b,
          newweight:e
        },
        success: function(result) {
            $( d ).load(window.location.href + " "+d+" > *");
			loadlistslider(b);
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