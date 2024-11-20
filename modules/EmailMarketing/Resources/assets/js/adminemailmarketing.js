function subscribe(e,email){
	b = $(e).parents('tr');
	b.find('td').hide();
	b.append('<td colspan="9"><div class="d-flex justify-content-center w-100 p-1"><i class="fas fa-spinner fa-pulse fa-lg"></i></div></td>');
	$.ajax({
        type:"POST",
        url: route('emailmarketing.admin.subscribe'),
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: csrf_token,
          email:email
        },
        success: function(result) {
            new PNotify({
                title: "Done",
                text: result,
                type: "success",
            });
            c = b.attr('class');
            $( '.'+c ).load(window.location.href + " ."+c+" > *");
        },
    })
}

function deleteemail(e,email){
    if (confirm(ConfirmAction) == true) {
    	b = $(e).parents('tr');
    	b.find('td').hide();
    	b.append('<td colspan="9"><div class="d-flex justify-content-center w-100 p-1"><i class="fas fa-spinner fa-pulse fa-lg"></i></div></td>');
    	$.ajax({
            type:"POST",
            url: route('emailmarketing.admin.deleteemail'),
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data: {
              _token: csrf_token,
              email:email
            },
            success: function(result) {
            	console.log(result);
                new PNotify({
                    title: "Done",
                    text: result,
                    type: "success",
                });
                c = b.attr('class');
                $( '.'+c ).load(window.location.href + " ."+c+" > *");
            },
        })
    }
}

function editcampaign(id){
    $('#formmodal').modal('show');
    $('#formmodal .modal-content').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
    $.ajax({
        type : 'GET',
        url : route('emailmarketing.admin.editcampaign',{id:id}),
        data : '',
        success : function(data) {
            $('#formmodal .modal-content').html(data);
        }
    });
}

function sentcampaign(e,id){
    b = $(e).parents('tr');
    b.find('td').hide();
    b.append('<td colspan="5"><div class="d-flex justify-content-center w-100 p-1"><i class="fas fa-spinner fa-pulse fa-lg"></i></div></td>');
    $.ajax({
        type:"POST",
        url: route('emailmarketing.admin.sentcampaign'),
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: csrf_token,
          id:id
        },
        success: function(result) {
            new PNotify({
                title: "Done",
                text: result,
                type: "success",
            });
            c = b.attr('class');
            $( '.'+c ).load(window.location.href + " ."+c+" > *");
        },
    })
}

function delcampaign(e,id){
    if (confirm(ConfirmAction) == true) {
        b = $(e).parents('tr');
        $.ajax({
            type:"DELETE",
            url: route('emailmarketing.admin.delcampaign'),
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data: {
              _token: csrf_token,
              id:id
            },
            success: function(result) {
                new PNotify({
                    title: "Done",
                    text: result,
                    type: "success",
                });
                b.remove();
            },
        })
    }
}

function viewreport(id){
    $('#formmodal').modal('show');
    $('#formmodal .modal-content').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
    $.ajax({
        type : 'GET',
        url : route('emailmarketing.admin.viewreport',{id:id}),
        data : '',
        success : function(data) {
            $('#formmodal .modal-content').html(data);
        }
    });
}

function adddomain(){
    $('#formmodal').modal('show');
    $('#formmodal .modal-content').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
    $.ajax({
        type : 'GET',
        url : route('emailmarketing.admin.adddomain'),
        data : '',
        success : function(data) {
            $('#formmodal .modal-content').html(data);
        }
    });
}

function entercode(domain){
    $('#formmodal').modal('show');
    $('#formmodal .modal-content').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
    $.ajax({
        type : 'GET',
        url : route('emailmarketing.admin.entercode',{domain:domain}),
        data : '',
        success : function(data) {
            $('#formmodal .modal-content').html(data);
        }
    });
}

function submitcode(domain){
    code = $('#code').val();
    $.ajax({
        type:"POST",
        url: route('emailmarketing.admin.entercode',{domain:domain}),
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: csrf_token,
          code:code
        },
        success: function(result) {
            $('.notify').html('<span class="text-success">'+result+'</span>');
            $('#formmodal').modal('hide');
            c = '.main';
            $( c ).load(window.location.href + " "+c+" > *");
        },
        error: function(result, status, error) {
            var err = JSON.parse(result.responseText);
            $('.notify').html('<span class="text-danger">'+err+'</span>');
        }
    })
}

function deletedomain(e,domain){
    if (confirm(ConfirmAction) == true) {
        b = $(e).parents('li');
        $.ajax({
            type:"DELETE",
            url: route('emailmarketing.admin.deletedomain'),
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data: {
              _token: csrf_token,
              domain:domain
            },
            success: function(result) {
                new PNotify({
                    title: "Done",
                    text: result,
                    type: "success",
                });
                b.remove();
            },
        })
    }
}