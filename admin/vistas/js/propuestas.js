$(document).on('keyup', "input[name='txtBuscarPropuesta']", function(){
	let buscar = $(this).val();
	if (buscar != '') {
		let datos = new FormData();
		datos.append('buscarPropuesta', buscar);
		datos.append('funcion', 'buscarPropuestas');
		$.ajax({
			url:"ajax/propuestas.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success:function(response){
				$('#cuerpoPropuestas').html('');
				$('#cuerpoPropuestas').html(response);
		    }
	  	});
	}
});

$(document).on('click','.accion', function(){
	let idPropuesta = $(this).attr('idPropuesta');
	let funcion = $(this).attr('funcion');
	swal({
		title: "¿Está seguro de "+$(this).attr('title')+"?",
		text: "¡Si no lo está puede cancelar la acción!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#0DAC7B',
		cancelButtonColor: "#D33",
		cancelButtonText: "¡Cancelar!",
		confirmButtonText: "Si, "+$(this).attr('title')+" propuesta" 
	}).then(function(result){
		if (result.value) {
			var datos = new FormData();
			datos.append("funcion", funcion);
			datos.append("idPropuesta", idPropuesta);
			$.ajax({
				url: 'ajax/propuestas.ajax.php',
				method: 'POST',
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(response){
					if (response == 'ok') {
						swal({
							title: "Correcto",
							text: "La acción fue relizada correctamente",
							type: "success",
							showConfirmButton: true,
							confirmButtonText: "¡Cerrar!",
							closeOnConfirm: false
						}).then(function(result){
							if (result.value) {
								window.location = "propuestas";
							}
						});
					}else{
						swal({
							type: "error",
							title: "¡ERROR!",
							text: "¡Ha ocurrido un problema al momento de realizar la acción",
							showConfirmButton: true,
							confirmButtonText: "cerrar"
						});
					}
				}
			});

		}
	});
});