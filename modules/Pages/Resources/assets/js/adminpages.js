function addpage(id) {
	$('#formmodal').modal('show');
	$('#formmodal .modal-content').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
	$.ajax({
		type : 'GET',
		url : route('pages.admin.addpage',{id:id}),
		data : '',
		success : function(data) {
			$('#formmodal .modal-content').html(data);
	        $('input[name="keyword"]').tagEditor({
	        	placeholder: 'keyword...'
	        });
	        $('#title').bind('mouseout',function(){
	            title = $(this).val();
	            slug = $('#slug').val();
	            title_old = $('#title_old').val();
	            slug_old = $('#slug_old').val();
	            spinner = '<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>';
	            if (title) {
	            	if (title != title_old || !title_old) {
			            $.ajax({
			                type : 'GET',
			                url : route('pages.admin.checktitleslug'),
			                data:{
			                	_token: csrf_token,
			                	title:title,
			                	slug:slug,
			                	type:'pages'
			                },
			                beforeSend: function(){
					            $('button[type="submit"]').prop('disabled', true);
					            $('.error-title').removeClass('text-danger').addClass('text-success').html(spinner);
					            $('.error-slug').removeClass('text-danger').addClass('text-success').html(spinner);
							},
			                success:function(data){
		                    	$('.error-title').html(data.title.msg);
		                    	$('.error-slug').html(data.slug.msg);
			                	if (data.title.check == 1) {
			                		$('.error-title').removeClass('text-success').addClass('text-danger');
			                	} else {
			                    	$('button[type="submit"]').prop('disabled', false);
			                	}
			                	if (data.slug.check == 1) {
			                		$('.error-slug').removeClass('text-success').addClass('text-danger');
			                	} else {
			                    	$('button[type="submit"]').prop('disabled', false);
			                	}
			                }
			            });
			        } else {
			        	$('button[type="submit"]').prop('disabled', false);
			            $('.error-title').empty();
			            $('.error-slug').empty();
			        }
	            } else {
		            $('.error-title').empty();
		            $('.error-slug').empty();
	            }
	        });
		}
	});
}

function changepagatype(){
    var pagetype = $('#pagetype').val();
    if(pagetype == 1){
    	$('#showlayout').show();
    	$('.inherittheme').hide();
    } else {
    	$('#showlayout').hide();
    	$('.inherittheme').show();
		$('#btnshowthumb').popover('hide');
    }
}
function getdemothumblayout(){
	var box = $("#layout");
	var win = $(window);
	win.on("click.Bst", function(event){
		var layout = $('#layout').val();
		domain = window.location.origin;
		img = '<img src="'+domain+'/modules/img/pages/'+layout+'.jpg" alt="">';
		if (box.has(event.target).length == 0 && !box.is(event.target)){
			$('#btnshowthumb').popover('hide');
		} else {
			$('#btnshowthumb').popover({
				container: 'body',
				toggle: 'popover',
				placement: 'bottom',
				content: '<div id=\'showthumblayout\'>'+img+'</div>',
				html: true
			}).popover('show');
			$('#showthumblayout').html(img);
		}
	});
}
function activepage(id) {
	$.ajax({
        url: route('pages.admin.activepage'),
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data : {_token: csrf_token,id:id},
        success: function(result) {
            var b = '#page'+id;
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
function delpage(id){
    if (confirm('Are You Sure?') == true) {
        $.ajax({
            url: route('pages.admin.delpage'),
            type: 'POST',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data : {_token: csrf_token,id:id},
            success: function(result) {
                var b = '#page'+id;
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
function chooseinterface(id,template){
    $.ajax({
        url: route('pages.admin.chooseinterface',{id:id}),
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data : {
        	_token: csrf_token,
        	template:template
        },
        success: function(result) {
            if(result.status == 'true'){
            	window.location.href = route('pages.admin.pagebuilder',{id:id});
            }
        }
    });
}
function addgroup(id) {
	$('#formmodal').modal('show');
	$('#formmodal .modal-content').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
	$.ajax({
		type : 'GET',
		url : route('pages.admin.addgroup',{id:id}),
		data : '',
		success : function(data) {
			$('#formmodal .modal-content').html(data);
	        $('#title').bind('mouseout',function(){
	            title = $(this).val();
	            slug = $('#slug').val();
	            title_old = $('#title_old').val();
	            slug_old = $('#slug_old').val();
	            spinner = '<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>';
	            if (title) {
	            	if (title != title_old || !title_old) {
			            $.ajax({
			                type : 'GET',
			                url : route('pages.admin.checktitleslug'),
			                data:{
			                	_token: csrf_token,
			                	title:title,
			                	slug:slug,
			                	type:'pagegroup'
			                },
			                beforeSend: function(){
					            $('button[type="submit"]').prop('disabled', true);
					            $('.error-title').removeClass('text-danger').addClass('text-success').html(spinner);
					            $('.error-slug').removeClass('text-danger').addClass('text-success').html(spinner);
							},
			                success:function(data){
		                    	$('.error-title').html(data.title.msg);
		                    	$('.error-slug').html(data.slug.msg);
			                	if (data.title.check == 1) {
			                		$('.error-title').removeClass('text-success').addClass('text-danger');
			                	} else {
			                    	$('button[type="submit"]').prop('disabled', false);
			                	}
			                	if (data.slug.check == 1) {
			                		$('.error-slug').removeClass('text-success').addClass('text-danger');
			                	} else {
			                    	$('button[type="submit"]').prop('disabled', false);
			                	}
			                }
			            });
			        } else {
			        	$('button[type="submit"]').prop('disabled', false);
			            $('.error-title').empty();
			            $('.error-slug').empty();
			        }
	            } else {
		            $('.error-title').empty();
		            $('.error-slug').empty();
	            }
	        });
		}
	});
}
function delgroup(id){
    if (confirm('Are You Sure?') == true) {
        $.ajax({
            url: route('pages.admin.delgroup'),
            type: 'DELETE',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data : {_token: csrf_token,id:id},
            success: function(result) {
                var b = '#group'+id;
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