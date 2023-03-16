$(document).ready(function(){
	mostrarDataTable('tablaPresidentes', 'tablaPresidentes.ajax.php');
	$('.select2').select2();
		let datos = new FormData();
	datos.append('funcion', 'contar');
	barraProgreso('presidente.ajax.php', datos, 'activos', 'porcentaje');
});

$(document).on("click", ".btnAgregarDireccion", function(){
	$("#formDireccion")[0].reset();
	$('#modalDireccion h4').html('Agregar dirección');
	$('#formAgregarComite button[type="submit"]').html('Agregar'); 
	let idPersona = $(this).attr('idPersona');
	$('input[name="funcion"]').val('agregarDireccion'); 
	$('input[name="idDireccion"]').val(''); 
	mostrarPersona(idPersona);
});

$(document).on('change', '#cmbDepartamentoDir', function(){
	idDepartamento = $(this).val();
	$("#cmbDepartamentoDir").find("option[value='']").remove();
	let funcion = 'mostrarProvincias';
	let datos = new FormData();
	datos.append("idDepartamento", idDepartamento);
	datos.append("funcion", funcion);
	let template ='';
	$.ajax({
		url:"ajax/direccion.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
	    success:function(response){
	    	response.forEach(valor =>{
				template +=`
					<option value="${valor.valor}">${valor.nombre}</option>
				`;
	    	});
	    	$('#cmbProvinciaDir').html(template);
	    	$('#cmbProvinciaDir').attr('disabled', false);
			idProvincia = $('#cmbProvinciaDir').val();
			let datos1 = new FormData();
			datos1.append("idProvincia", idProvincia);
			datos1.append("funcion", 'mostrarDistritos');
			mostrarDatosCmb(datos1, 'direccion.ajax.php', 'cmbDistritoDir', 0);
	    }
  	});

});

$(document).on('change', '#cmbProvinciaDir', function(){
	idProvincia = $(this).val();
	let funcion = 'mostrarDistritos';
	let datos = new FormData();
	datos.append("idProvincia", idProvincia);
	datos.append("funcion", funcion);
	mostrarDatosCmb(datos, 'direccion.ajax.php', 'cmbDistritoDir');

});


$(document).on('click', '.editarDireccion', function(){
	$("#formDireccion")[0].reset();
	$('#modalDireccion h4').html('Editar dirección');
	$('#formDireccion button[type="submit"]').html('Guardar'); 
	let idPersona = $(this).attr('idPersona');
	let idDireccion = $(this).attr('idDireccion');
	mostrarPersona(idPersona);
	$('input[name="funcion"]').val('editarDireccion'); 
	$('input[name="idDireccion"]').val(idDireccion); 
	$('#formAgregarComite button[type="submit"]').html('Agregar'); 
	if (typeof idDireccion !== "undefined" || idDireccion !== null){
		let datos = new FormData();
		datos.append('idDireccion', idDireccion);
		datos.append('funcion', 'buscarDireccion');
		$.ajax({
			url:"ajax/direccion.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			success:function(response){
				$("#cmbDepartamentoDir").find("option[value='']").remove();
				$('#cmbDepartamentoDir').val(response['idDepartamento']);
				let datos = new FormData();
				datos.append("idDepartamento", response['idDepartamento']);
				datos.append("funcion", 'mostrarProvincias');
				mostrarDatosCmb(datos, 'direccion.ajax.php', 'cmbProvinciaDir', response['idProvincia']);
				let datos1 = new FormData();
				datos1.append("idProvincia", response['idProvincia']);
				datos1.append("funcion", 'mostrarDistritos');
				mostrarDatosCmb(datos1, 'direccion.ajax.php', 'cmbDistritoDir', response['idDistrito']);
				$('input[name="txtDireccion"]').val(response['nombreDireccion']); 
				$('input[name="txtNumeroDir"]').val(response['numero']); 
				$('textarea[name="txtDescripcionDir"]').val(response['descripcion']); 
		    }
	  	});
	}
});

$(document).on("click", ".editarPresidente", function(){
	$("#formPresidente")[0].reset();
	let idPresidente = $(this).attr('idPresidente');
	let datos = new FormData();
	datos.append('idPresidente', idPresidente);
	datos.append('funcion', 'mostrarPresidente');
	$.ajax({
		url: "ajax/presidente.ajax.php",
		method: "POST",
  		data: datos,
  		cache: false,
		contentType: false,
    	processData: false,
    	dataType: "json",
		success:function(response){
			$('input[name="txtDniPresidente"]').val(response['dniPersona']);
			$('input[name="txtApellidoPaterno"]').val(response['apellidoPaternoPersona']);
			$('input[name="txtApellidoMaterno"]').val(response['apellidoMaternoPersona']);
			$('input[name="txtNombrePresidente"]').val(response['nombrePersona']);
			$('input[name="dateFechaPresidente"]').val(response['fechaRegistroPresidente']);
			$('input[name="txtCorreoPresidente"]').val(response['correoPresidente']);
			$('input[name="txtCelularPresidente"]').val(response['celularPresidente']);
			$('#formPresidente input[name="idPresidente"]').val(response['idPresidente']);
			$('#formPresidente input[name="funcion"]').val('editarPresidente');
		}
	});
});

$(document).on('change', '#cmbLocalidad', function(){
	$("#cmbLocalidad").find("option[value='']").remove();
	let idLocalidad = $(this).val();
	if (idLocalidad == 0) {
		buscarEnTabla('tablaPresidentes', 'tablaPresidentes.ajax.php', null);
	}else if(idLocalidad > 0){
		let datos = new FormData();
		datos.append('funcion', 'mostrarLocalidad');
		datos.append('idLocalidad', idLocalidad);
		buscarEnTabla('tablaPresidentes', 'tablaPresidentes.ajax.php', datos);
	}
});

$(document).on("click", "#btnActivos", function(){
	let estado = $(this).attr('estado');
	let idLocalidad = $('#cmbLocalidad').val();
	let datos = new FormData();
	datos.append('funcion', 'mostrarActivos');
	datos.append('estado', estado);
	buscarEnTabla('tablaPresidentes', 'tablaPresidentes.ajax.php', datos);	
	if (estado == 1) {
		$(this).removeClass('btn-warning');
		$(this).addClass('btn-secondary');
		$(this).html('Ver presidentes inactivos'); 
		$(this).attr('estado', 0);
	}else{
		$(this).removeClass('btn-secondary');
		$(this).addClass('btn-warning');
		$(this).html('Ver presidentes activos'); 
		$(this).attr('estado', 1);
	}	

});
$(document).on("submit", "#formDireccion", function(event){
	$.ajax({
		url:"ajax/direccion.ajax.php",
		method: "POST",
		data: $('#formDireccion').serialize(),
		cache: false,
		success:function(response){
			if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡La accion se ejecuto con exito con exito!', 'success');
				$("#formDireccion")[0].reset();
				$("#modalDireccion").modal('hide');
				buscarEnTabla('tablaPresidentes', 'tablaPresidentes.ajax.php', null);	
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});


function mostrarPersona(idPersona){
	if (typeof idPersona !== "undefined" || idPersona !== null){
		let datos = new FormData();
		datos.append('idPersona', idPersona);
		datos.append('funcion', 'buscarId');
		$.ajax({
			url:"ajax/personas.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			success:function(response){
				$('input[name="txtPresidente"]').val(response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']+', '+response['nombrePersona']); 
				$('input[name="idPersona"]').val(idPersona); 
		    }
	  	});
	}
}