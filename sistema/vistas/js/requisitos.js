$(document).on('click', '#btnAgregarRequisito', function(){
	$("#formAgregarRequisito")[0].reset();
});

$(document).on("click", ".editarRequisito", function(){
	let idRequisito = $(this).attr('idRequisito');
	let datos = new FormData();
	datos.append('idRequisito', idRequisito);
	datos.append('funcion', 'mostrarRequisito');
	$.ajax({
		url: "ajax/requisitos.ajax.php",
		method: "POST",
  		data: datos,
  		cache: false,
		contentType: false,
    	processData: false,
    	dataType: "json",
		success:function(response){
			$('input[name="txtEditarRequsito"]').val(response['nombreRequisito']);
			$('textarea[name="txtEditarDescripcionReq"]').val(response['descripcionRequisito']);
			$('input[name="idRequisitos"]').val(response['idRequisito']);
		}
	});
});