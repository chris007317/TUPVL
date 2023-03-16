$(document).on("click", ".editarTipoBeneficiario", function(){
	let idTipoBeneficiario = $(this).attr('idTipoBeneficiario');
	let datos = new FormData();
	datos.append('idTipoBeneficiario', idTipoBeneficiario);
	datos.append('funcion', 'mostrarTipoBeneficiario');
	$.ajax({
		url: "ajax/tipo-beneficiario.ajax.php",
		method: "POST",
  		data: datos,
  		cache: false,
		contentType: false,
    	processData: false,
    	dataType: "json",
		success:function(response){
			$('input[name="txtEditarTipoBeneficiario"]').val(response['nombreTipoBeneficiario']);
			$('textarea[name="txtEditarDescripcionTipoBenef"]').val(response['descripcion']);
			$('input[name="idTipoBeneficiario"]').val(response['idTipoBeneficiario']);
		}
	});
});