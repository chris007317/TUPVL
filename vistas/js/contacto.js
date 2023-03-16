$(document).on("submit", "#enviarCorreo", function(event){
	$.ajax({
		url:"ajax/consulta.ajax.php",
		method: "POST",
		data: $('#enviarCorreo').serialize(),
		cache: false,
		success:function(response){
			if (response == 'ok') {
				msjModal('El mensaje se envi¨® con exito', 'Mensaje enviado');
				$("#formDireccion")[0].reset();
			}else {
				msjModal('El mensaje no se envi¨®', 'ERROR');
			}
	    }
  	});
	event.preventDefault();
});

function msjModal(mensaje, titulo){
	let mensajeModal = '<div class="modal_wrap">'+
	    '<div class="mensaje_modal">'+
	        '<h3>'+titulo+'</h3>'+
	        '<p><i class="fas fa-times"></i> '+mensaje+'</p>'+
	        '<span id="btnClose">Cerrar</span>'+
	    '</div>'+
	'</div>';
	$('body').append(mensajeModal);
	$('#btnClose').click(function(){
	$('.modal_wrap').remove();
	});
}