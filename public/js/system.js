$('[data-toggle="popover"]').popover();

function redirectroute(route) {
    window.location.href = route;
}

function open_browse(route,name,w,h,features) {
    LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
    TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
    settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition;
    if(features != '') {
        settings = settings + ','+features;
    }
    window.open(route,name,settings);
    return false;
}

function open_popup(url) {
    var w = 880;
    var h = 570;
    var l = Math.floor((screen.width - w) / 2);
    var t = Math.floor((screen.height - h) / 2);
    var win = window.open(url, 'ResponsiveFilemanager', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
}

function displayimgVals(a, b) {
    var singleValues = $(a).val();
    $(b).animate({
        width : "toggle",
        height : "toggle",
        opacity : .5
    }, 700, function() {
        $(this).attr("src", singleValues).animate({
            width : "toggle",
            height : "toggle",
            opacity : 1
        }, 700);
    });
}

function uploadimg(a, b) {
    $(a).change(displayimgVals(a, b));
}

function loadaddwidget(route) {
    $('#showaddwidget').html('<div class="modal-body"><div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></div></div>');
    setTimeout(function() {
        $.ajax({
            url: route,
            type: 'GET',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data: {
              _token: "<?php echo csrf_token(); ?>"
            },
            success: function(result) {
                $('#showaddwidget').html(result);
            }
        });
    }, 300);
}

function actionsys(a,b,c) {
    if (confirm('Are You Sure?') == true) {
    	$.ajax({
            url: a,
            type: 'POST',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data: {
              _token: "<?php echo csrf_token(); ?>"
            },
            success: function(result) {
            	$( b ).load(window.location.href + " "+b+" > *");
                if (c != undefined){
                    $( c ).load(window.location.href + " "+c+" > *");
                }
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

function actiontable(route) {
    $.ajax({
        url: route,
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: csrf_token
        },
        success: function(result) {
            reload_table();
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

function changeweightsys(a,b,c,d) {
    var e = document.getElementById(b).options[document.getElementById(b).selectedIndex].value;
    $.ajax({
        url: a+"/"+e,
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: "<?php echo csrf_token(); ?>"
        },
        success: function(result) {
            $( c ).load(window.location.href + " "+c+" > *");
            if (d != undefined){
                $( d ).load(window.location.href + " "+d+" > *");
            }
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
function changeweighttalbe(a,b) {
    var e = document.getElementById(b).options[document.getElementById(b).selectedIndex].value;
    $.ajax({
        url: a+"/"+e,
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: "<?php echo csrf_token(); ?>"
        },
        success: function(result) {
            reload_table();
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

function deletesys(a,b,c,d) {
    if (confirm(d) == true) {
        $.ajax({
            url: a,
            type: 'POST',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data: {
              _token: "<?php echo csrf_token(); ?>"
            },
            success: function(result) {
                $( b ).load(window.location.href + " "+b+" > *");
                if (c != undefined){
                    $( c ).load(window.location.href + " "+c+" > *");
                }
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

function deltable(route,a) {
    if (confirm(a) == true) {
        $.ajax({
            url: route,
            type: 'POST',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data: {
              _token: "<?php echo csrf_token(); ?>"
            },
            success: function(result) {
                reload_table();
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

function deletewidget(a,b,c) {
    if (confirm(c) == true) {
        $.ajax({
            url: a,
            type: 'POST',
            contentType: "application/x-www-form-urlencoded;charset=utf-8",
            data: {
              _token: "<?php echo csrf_token(); ?>"
            },
            success: function(result) {
                $( b ).remove();
                new PNotify({
                    title: "Done",
                    text: result,
                    type: "success",
                    addclass: "stack-bottomright",
                    animate: {
                        animate: true,
                        in_class: 'zoomInLeft',
                        out_class: 'zoomOutRight'
                    }
                });
            }
        });
    }
}
function getData(page,a){
    $.ajax(
    {
        url: '?page=' + page,
        type: "get",
        datatype: "html"
    }).done(function(data){
        $(a).empty().html(data);
        location.hash = page;
    }).fail(function(jqXHR, ajaxOptions, thrownError){
        alert('No response from server');
    });
}

// function DrapNDrop(a,b,c){var post_order=false; $(a).sortable({connectWith: a, opacity: 0.6, placeholder: 'placeholder', receive : function(){post_order=true; var position=$(this).attr("id"); var weight=$(this).sortable('toArray'); $.ajax({url:b, method:"POST", data:{_token: "<?php echo csrf_token(); ?>", weight:weight, wggroup:position, place:c}, success:function(data){new PNotify({title: "Done", text: data, type: "success",});}});}, stop : function(){if (post_order==false){var weight=$(this).sortable('toArray'); $.ajax({url:b, method:"POST", data:{_token: "<?php echo csrf_token(); ?>", weight:weight}, success:function(data){new PNotify({title: "Done", text: data, type: "success",});}});}}});}

function DrapNDrop(a,b,c){
    var post_order=false; 
    $(a).sortable({
        connectWith: a, 
        revert: "invalid",
        scroll: true,
        opacity: 0.6, 
        placeholder: 'placeholder', 
        receive : function(){
            post_order=true; 
            var position=$(this).attr("id"); 
            var weight=$(this).sortable('toArray'); 
            $.ajax({
                url:b, 
                method:"POST", 
                data:{
                    _token: csrf_token, 
                    weight:weight, 
                    wggroup:position, 
                    place:c
                }, 
                success:function(data){
                    new PNotify({
                        title: "Done", 
                        text: data, 
                        type: "success",
                    });
                }
            });
        }, 
        stop : function(){
            if (post_order==false){
                var weight=$(this).sortable('toArray'); 
                $.ajax({
                    url:b, 
                    method:"POST", 
                    data:{
                        _token: "<?php echo csrf_token(); ?>", 
                        weight:weight
                    }, 
                    success:function(data){
                        new PNotify({
                            title: "Done", 
                            text: data, 
                            type: "success",
                        });
                    }
                });
            }
        }
    });
}


function ChangeToSlug(a,b,c)
{
    var title, slug;
    title = document.getElementById(a).value;
    slug = title.toLowerCase();
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    slug = slug.replace(/ /gi, "-");
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    slug = slug.replace(/([^0-9a-z-\s])/gi, '');
    slug = slug.replace(/(\s+)/gi, '-');
    slug = slug.replace(/^-+/gi, '');
    slug = slug.replace(/-+$/gi, '');
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    document.getElementById(b).value = slug;
    $('#'+c).text(slug);
}
function ChangeToSlugAjax(a,b,c,d)
{
    $.get(a, 
      { 'title': $('#'+b).val() }, 
      function( data ) {
        document.getElementById(c).value = data.slug;
        $('#'+d).text(data.slug);
      }
    );
}

function text_length(a, b, c) {
    if (document.getElementById(a).value.length > c) {
        document.getElementById(a).value = document.getElementById(a).value.substring(0, c);
    }
    else {
        $('#desclength').text(c - document.getElementById(a).value.length);
    }
}
function ChangeInputSlug(a){
    $('#'+a).text(event.target.value);
}
function BTshowIPSlug(a,b,c){
    var pwdType = $("#"+a).attr("type");
    var newType = (pwdType === "hidden")?"text":"hidden";
    $("#"+c+" i").toggleClass('fa-check').toggleClass('fa-pencil-alt');
    $( "#"+b ).toggle();
    $("#"+a).attr("type", newType);
}

function backpage(){
    parent.history.back();
    return false;
}

function reloadpage(){
    location.reload();
}
function reload_table() {
  // table.ajax.reload(null, false); //reload datatable ajax
  b = 'tbody';
  $( b ).load(window.location.href + " "+b+" > *");
}
function percentage(a,b,c){
    var percentage = Math.floor(((document.getElementById(a).value - document.getElementById(b).value )/document.getElementById(a).value)*100);
    document.getElementById(c).value = (document.getElementById(b).value > 0)?percentage:0;
}

function loadScript(src) {
  let script = document.createElement('script');
  script.src = src;
  script.async = false;
  document.body.append(script);
}