var triggerTabList = [].slice.call(document.querySelectorAll('#InterfaceTabs a'))
triggerTabList.forEach(function (triggerEl) {
  var tabTrigger = new bootstrap.Tab(triggerEl)

  triggerEl.addEventListener('click', function (event) {
    event.preventDefault()
    tabTrigger.show()
  })
})

function sentiment(type,id){
	console.log(type+'-'+id);
	$.ajax({
        url: route('interfacepackage.web.sentiment'),
        type: 'POST',
        contentType: "application/x-www-form-urlencoded;charset=utf-8",
        data: {
          _token: csrf_token,
          id:id,
          type:type
        },
        success: function(result) {
        	if (result.status === 'success') {
	            toastr.success(result.mes, {timeOut: 5000});
            	$('#btnsentiment').load(window.location.href + " #btnsentiment > *");
            	$('#sentiment').load(window.location.href + " #sentiment > *");
	        } else if (result.status === 'warning') {
	        	toastr.warning(result.mes, {timeOut: 5000});
	        } else {
	        	toastr.error(result.mes, {timeOut: 5000});
	        }
        }
    });
}