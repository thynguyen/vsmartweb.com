function addgroup(id) {
    $('#formmodal').modal('show');
    $('#addgroup').html('<div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div>');
    $.ajax({
        type : 'GET',
        url : route('menus.admin.addgroup',{id:id}),
        data : '',
        success : function(data) {
            $('#addgroup').html(data);
        }
    });
}
function delgroup(id) {
    $.ajax({
        type : 'DELETE',
        url : route('menus.admin.delgroup'),
        data : {_token: csrf_token,id:id},
        success : function(data) {
            console.log(data)
            if (data.success == 1) {
                new PNotify({
                    title: "Done",
                    text: data.messages,
                    type: "success",
                });
                b = '.list-group';
                $( b ).load(window.location.href + " "+b+" > *");
            } else {
                new PNotify({
                    title: "Error",
                    text: data.messages,
                    type: "error",
                });
            }
        }
    });
}
function loadlistmenu(id){
    closeform()
    $('#listmenus .card-body').append('<div id="maskpin"><div class="loading rounded"><i class="fas fa-spinner fa-spin mr-1"></i> Loading</div><div class="maskbg rounded"></div></div>');
    $.ajax({
        type : 'GET',
        url : route('menus.admin.listmenus',{groupid:id}),
        data : '',
        success : function(data) {
            $('#listmenus').html(data);
            DrapNDropMenu(id);
        }
    });
}

function addmenu(groupid,id) {
    $('#listmenus').removeClass('showpanel',function() {
        setTimeout(function() {
            $('#formcreatemenu').addClass('showpanel').html('<div class="card"><div class="card-body text-center"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</div></div>');
        }, 100);
    });
    $.ajax({
        type : 'GET',
        url : route('menus.admin.addmenu',[groupid,id]),
        data : '',
        success : function(data) {
            $('#formcreatemenu').html(data);
            $("#iconvalue").fontIconPicker({
                theme: 'fip-darkgrey'
            });
            // $('.icon').iconpicker().iconpicker('setIconset','fontawesome5_pro');
            $(function(){
                $("input[name=urltype]").click(function(){
                    var type = $(this).val();
                    if (type=="url"){
                        $("#typeurl").show();
                    } else {
                        $("#typeurl").hide();
                    }
                    if (type=="route"){
                        $("#typeroute").show();
                    } else {
                        $("#typeroute").hide();
                    }
                });
            });
            $( "#listmenu" ).draggable({
                scroll: true,
                axis: "x",
                containment: "body",
                revert: true,
                helper: "clone",
                disable: false,
                start: function( event, ui ) {
                        $(ui.item).addClass("active-draggable");
                },
                drag: function( event, ui ) {
                },
                stop:function( event, ui ) {
                        $(ui.item).removeClass("active-draggable");
                }
            });
        }
    });
}
function submitaddmenu(groupid,id){
    parentold = $('#parentold').val();
    title = $('#title').val();
    parentid = $('#parentid').val();
    urltype = $('input[name=urltype]:checked').val();
    url = $('#url').val();
    routemenu = $('#route').val();
    icon = $('#iconvalue').val();
    target = $('#target').val();
    mod = $('#module').val();
    // id = (id !== 'null')?id:'';
    // console.log(parentold+'-'+title+'-'+parentid+'-'+urltype+'-'+url+'-'+route+'-'+icon+'-'+id);
    $.ajax({
        type : 'POST',
        url : route('menus.admin.postaddmenu'),
        data : {
            _token: csrf_token,
            id:id,
            groupid:groupid,
            parentold:(!parentold)?'':parentold,
            parentid:parentid,
            icon:(!icon)?'':icon,
            title:title,
            urltype:urltype,
            url:url,
            target:target,
            route:routemenu,
            module:mod
        },
        success : function(data) {
            console.log(data)
            closeform();
            b = '#listmenu';
            $( b ).load(window.location.href + " "+b+" > *");
            loadlistmenu(groupid);
            new PNotify({
                title: "Done",
                text: data.msg,
                type: "success",
            });
        }
    });
}
function closeform(){
    $('#formcreatemenu').removeClass('showpanel',function() {
        setTimeout(function() {
            $('#listmenus').addClass('showpanel');
        }, 300);
    });
}

function DrapNDropMenu(groupid){
    var drapid = 'ul.itemmenus';
    var rt = route('menus.admin.changeweightdrop');
    var post_order=false;
    var oldParent, newList, item,weight;
    $(drapid).sortable({
        connectWith:drapid,
        revert: "invalid",
        scroll: true,
        opacity: 0.6, 
        placeholder: 'pf_sortable-placeholder', 
        items: '> li',
        tolerance: 'pointer',
        cursor: 'pointer',
        cursorAt: {
            top: -20
        },
        zIndex: 20000,
        start: function (event, ui) {
            item = ui.item;
            newList = oldParent = ui.item.parent();
            $(drapid).addClass('show');
            $('.collapse').addClass('d-block');
            ui.item.find('ul').removeClass('show');
        },
        stop : function(event, ui){
            $(drapid).removeClass('show');
            $('.collapse').removeClass('d-block');

            itemparent = ui.item.parent();
            post_order=true;
            var parentidold=oldParent.data("parent");
            var parentid= itemparent.data("parent");
            var id = ui.item.attr('id');
            weight=$(this).sortable('toArray'); 
            $.ajax({
                url:rt, 
                method:"POST", 
                data:{
                    _token: csrf_token, 
                    weight:weight, 
                    parentid:parentid,
                    parentidold:parentidold,
                    id:id,
                    groupid:groupid
                }, 
                success:function(data){
                    if (parentidold !== parentid) {
                        loadlistmenu(groupid);
                    }
                    new PNotify({
                        title: "Done", 
                        text: data, 
                        type: "success",
                    });
                    post_order=false;
                }
            });
        }
    }).disableSelection();
}
function delmenu(groupid,id){
    if (confirm('Are You Sure?') == true) {
        $.ajax({
            type : 'DELETE',
            url : route('menus.admin.delmenu'),
            data : {_token: csrf_token,id:id},
            success : function(data) {
                new PNotify({
                    title: "Done",
                    text: data,
                    type: "success",
                });
                loadlistmenu(groupid);
            }
        });
    }
}
function getlistmenumod(e,link=''){
    var mod = $(e).val();
    $('#showurl').empty();
    $('#showlistmenumod').append('<div id="maskpin"><div class="loading rounded"><i class="fas fa-spinner fa-spin mr-1"></i> Loading</div><div class="maskbg rounded"></div></div>');
    $.ajax({
        type : 'POST',
        url : route('menus.admin.getlistmenumod'),
        data : {
            _token: csrf_token,
            module:mod,
            link:link
        },
        success : function(data) {
            $('#showlistmenumod').html(data);
            getlinkmenu('#route');
        }
    });
}

function getlinkmenu(e){
    var link = $(e).val();
    $('#showurl').text(link);
}