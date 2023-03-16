
$(document).ready(function(){
	$('.select2').select2();	
	mostrarDataTable('tablaEntregados', 'tablaEntregados.ajax.php');
});

$(document).on('change', '#cmNombreMes', function(){
	$("#cmNombreMes").find("option[value='']").remove();
});

$(document).on('click', '#btnVerEntrega', function(){
	let idMes = $("#cmNombreMes").val(); 
	let year = $("#cmbYear").val(); 
	let datos = new FormData();
	datos.append('idMes', idMes);
	datos.append('year', year);
	datos.append('funcion', 'buscarPorMes');
	buscarEnTabla('tablaEntregados', 'tablaEntregados.ajax.php', datos);	
});

$(document).on('click', '.editarSalida', function(){
	let idSalida = $(this).attr('idSalida');
	let datos = new FormData();
	datos.append('idSalida', idSalida);
	datos.append('funcion', 'mostrarSalida');
	$.ajax({
		url:"ajax/almacen.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
	    success:function(response){
	    	$('#nombreComite').html(response['nombreComite']);
	    	$('#nombreAlimento').html(response['nombreProducto'] + ' - ' + response['marcaProducto']);
	    	$('#fechaHoraAlimento').html(response['fechaEntrega']);
	    	$('#cantAlimento').html(response['cantidad']);
	    	$('input[name="idSalida"]').val(response['idSalidaProducto']); 
	    	$('textarea[name="txtObservacionSalida"]').val(response['observacion']); 
	    }
  	});
});

$(document).on("submit", "#formEditarSalida", function(event){
	$.ajax({
		url:"ajax/almacen.ajax.php",
		method: "POST",
		data: $('#formEditarSalida').serialize(),
		cache: false,
		success:function(response){
			if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡No se permiten carácteres especiales!', 'warning');
			}else if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡La accion se ejecuto con exito con exito!', 'success');
				let idMes = $("#cmNombreMes").val(); 
				let year = $("#cmbYear").val(); 
				if (idMes == '') {
					buscarEnTabla('tablaEntregados', 'tablaEntregados.ajax.php', null);
				}else{
					let datos = new FormData();
					datos.append('idMes', idMes);
					datos.append('year', year);
					datos.append('funcion', 'buscarPorMes');
					buscarEnTabla('tablaEntregados', 'tablaEntregados.ajax.php', datos);	
				}
				$("#editarSalida").modal('hide');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador de inmediato.' , 'error');
			}
	    }
  	});

	event.preventDefault();
});