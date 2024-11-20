function getformcontact(){
  $('#formmodal').modal('show');
  $('#formmodal .modal-content').html('<div class="modal-body"><div class="d-flex justify-content-center w-100 p-3"><i class="fas fa-spinner fa-pulse fa-2x"></i></div></div>');
  $.ajax({
    type : 'GET',
    url : route('contact.web.getformcontact'),
    data : '',
    success : function(data) {
      $('#formmodal .modal-content').html(data);
    }
  });
}