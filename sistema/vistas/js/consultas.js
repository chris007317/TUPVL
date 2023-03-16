$(document).ready(function(){
	$('.select2').select2();
});

$(document).on('change', '#cmbTipoConsulta', function(){
	$("#cmbTipoConsulta").find("option[value='']").remove();
});

$(document).on('click', '#btnConsulta', function(){
	let dni = $('input[name="txtDniPersona"]').val();
	let tipo = $('#cmbTipoConsulta').val();
	if (dni.length == 8 && (/^\d{8}$/.test(dni)) && tipo != '') {
		let datos = new FormData();
		datos.append("cmbTipoConsulta", tipo);
		datos.append("txtDniPersona", dni);
		$.ajax({
			url:"ajax/consultas.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success:function(response){
				$('#datosPersona').html(response['persona']);
				$('#tablaConsulta').html(response['template']);
			}
		});

	}else{
		alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', 'Vuelva a intentar');	
	}
});