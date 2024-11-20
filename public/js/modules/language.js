function getlang(a) {
    b = $('#getcountry').val();
    $.ajax({
        url: a+'/'+b,
        type: 'GET',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: csrf_token
        },
        success: function(data) {
            $('#name').val(data.name);
            $('#locale').val(data.locale);
            $('#regional').val(data.code);
            $('#script').val(data.script);
            $('#native').val(data.native);
            $('#flag').val(data.flag).trigger("change");
            if (data.findlang == 1) {
                $('#findlang').removeClass().addClass('help-block text-success');
            } else {
                $('#findlang').removeClass().addClass('help-block text-danger');
            }
            $('#findlang').html(data.notefindlang);
        }
    });
}

function getfolderlang(a){
    b = $('#getfolderlang').val();
    $.ajax({
        url: a+'/'+b,
        type: 'GET',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: "<?php echo csrf_token(); ?>"
        },
        success: function(data) {
            $('#content_folder_lang').html(data);
            $('#content_file_lang').html('Loading...');
            setTimeout(function() {
                $('#content_file_lang').html('');
            }, 300);
        }
    });
}

function getfilelang(a,b){
    c = $(b).val();
    window.location.href = a+'/'+c;
}

function exportlang(a){
    $.ajax({
        url: a,
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: "<?php echo csrf_token(); ?>"
        },
        success: function(result) {
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

function getdatalang(a){
    $.ajax({
        url: a,
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: "<?php echo csrf_token(); ?>"
        },
        beforeSend: function() {},
        success: function(result) {
            $('.loading').remove();
            $('.text-loading').removeClass('text-info').addClass('text-success').html('<i class="fas fa-check fa-2x mr-2"></i>'+result);
            setTimeout(function() {
                location.reload();
            }, 2000);
        }
    });
}

function formatState (state) {
  if (!state.id) {
    return state.text;
  }
  var $state = $(
    '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" width="18px" /> ' + state.text + '</span>'
  );
  return $state;
};

$("#flag").select2({
    theme: "bootstrap",
    language: langsite,
    placeholder: placeholder,
    allowClear: true,
    templateResult: formatState,
    templateSelection: formatState
});
$("#getfolderlang").select2({
    theme: "bootstrap",
    language: langsite,
    placeholder: placeholder,
    allowClear: true
});
$("#getcountry").select2({
    theme: "bootstrap",
    language: langsite
});
