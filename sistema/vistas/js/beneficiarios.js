$(document).ready(function(){
	mostrarDataTable('tablaBeneficiarios', 'tablaBeneficiarios.ajax.php');
	$('.select2').select2();
});


$(document).on('change', '#cmbEstadoPostulantes', function(){
	$(this).find("option[value='']").remove();
});


$(document).on('change', '#cmbDepartamentoDir', function(){
	idDepartamento = $(this).val();
	$("#cmbDepartamentoDir").find("option[value='']").remove();
	let funcion = 'mostrarProvincias';
	let datos = new FormData();
	datos.append("idDepartamento", idDepartamento);
	datos.append("funcion", funcion);
	mostrarProvinciaDistrito(datos, 'cmbProvinciaDir', 'cmbDistritoDir')
	
});

$(document).on('change', '#cmbDepartamentoSocio', function(){
	idDepartamento = $(this).val();
	$("#cmbDepartamentoSocio").find("option[value='']").remove();
	let funcion = 'mostrarProvincias';
	let datos = new FormData();
	datos.append("idDepartamento", idDepartamento);
	datos.append("funcion", funcion);
	mostrarProvinciaDistrito(datos, 'cmbProvinciaSocio', 'cmbDistritoSocio')
	
});

function mostrarProvinciaDistrito(datos, cmbProvincia, cmbDistrito){
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
	    	$('#'+cmbProvincia).html(template);
	    	$('#'+cmbProvincia).attr('disabled', false);
			idProvincia = $('#'+cmbProvincia).val();
			let datos1 = new FormData();
			datos1.append("idProvincia", idProvincia);
			datos1.append("funcion", 'mostrarDistritos');
			mostrarDatosCmb(datos1, 'direccion.ajax.php', cmbDistrito, 0);
	    }
  	});
}

$(document).on('change', '#cmbProvinciaDir', function(){
	idProvincia = $(this).val();
	let funcion = 'mostrarDistritos';
	let datos = new FormData();
	datos.append("idProvincia", idProvincia);
	datos.append("funcion", funcion);
	mostrarDatosCmb(datos, 'direccion.ajax.php', 'cmbDistritoDir');
});

$(document).on('change', '#cmbProvinciaSocio', function(){
	idProvincia = $(this).val();
	let funcion = 'mostrarDistritos';
	let datos = new FormData();
	datos.append("idProvincia", idProvincia);
	datos.append("funcion", funcion);
	mostrarDatosCmb(datos, 'direccion.ajax.php', 'cmbDistritoSocio');
});

$(document).on('change', '#cmbLocalidad', function(){
	idLocalidad = $(this).val();
	let funcion = 'mostrarComites';
	let datos = new FormData();
	datos.append("idLocalidad", idLocalidad);
	datos.append("funcion", funcion);
	mostrarDatosCmb(datos, 'comite.ajax.php', 'cmbComite');
});

$(document).on('change', '#cmbLocalidadBenef', function(){
	idLocalidad = $(this).val();
	let funcion = 'mostrarComites';
	let datos = new FormData();
	$("#cmbLocalidadBenef").find("option[value='']").remove();
	if (idLocalidad == 0) {
		$("#cmbComiteBenef").attr("disabled", "disabled");
		$("#cmbComiteBenef").html('');
		$('#cmbComiteBenef').prepend("<option value='' >Elija Localidad</option>");
	}else{
		datos.append("idLocalidad", idLocalidad);
		datos.append("funcion", funcion);
		mostrarDatosCmb(datos, 'comite.ajax.php', 'cmbComiteBenef');
	}
});


$(document).on('click', '.editarDireccion', function(){
	$("#formDireccion")[0].reset();
	$('#modalDireccion h4').html('Editar dirección');
	$('#formDireccion button[type="submit"]').html('Guardar'); 
	let idPersona = $(this).attr('idPersona');
	let idDireccion = $(this).attr('idDireccion');
	$('#formDireccion input[name="funcion"]').val('editarDireccion'); 
	$('#formDireccion input[name="idDireccion"]').val(idDireccion); 
	mostrarPersona(idPersona);
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
				if (btnVer == true) {
					verTabla();
				}else if(btnBuscar == true){
					verTablaFecha();
				}else{
					buscarEnTabla('tablaBeneficiarios', 'tablaBeneficiarios.ajax.php', '');
				}
				
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});

$(document).on('click', '.verSocio', function(){
	limpiarDatosSocio();
	let idSocio = $(this).attr('idSocio');
	let datos = new FormData();
	datos.append("idSocio", idSocio);
	datos.append("funcion", 'mostrarSocio');
	$.ajax({
		url:"ajax/socio.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success:function(response){
			$('#socioNombre').html(response.apellidoPaternoPersona + ' ' + response.apellidoMaternoPersona + ', ' + response.nombrePersona);
			$('#socioDni').html(response.dniPersona);
			$('#socioUbicacion').html(response.nombreDepartamento + ', ' + response.nombreProvincia + ', ' + response.nombreDistrito);
			$('#socioDireccion').html(response.nombreDireccion + ' N° ' + response.numero);
			$('#socioCelular').html(response.celular);
			$('#socioCorreo').html(response.correoSocio);
		}
	});
});

$(document).on('click', '.verBeneficiario', function(){
	let idBeneficiario = $(this).attr('idBeneficiario');
	let idEstadoBenef = $(this).attr('idEstadoBenef');
	let datos = new FormData();
	limpiarDatosPostulante();
	datos.append("idBeneficiario", idBeneficiario);
	datos.append("idEstado", idEstadoBenef);
	datos.append("funcion", 'datosBeneficiario');
	$.ajax({
		url:"ajax/beneficiario.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success:function(response){
			$('#beneficiarioNombre').html(response.apellidoPaternoPersona + ' ' + response.apellidoMaternoPersona + ', ' + response.nombrePersona);
			$('#benficiarioDni').html(response.dniPersona);
			$('#fechaNacimiento').html(response.fechaNacimiento);
			$('#beneficiarioEdad').html(response.edadPostulante);
			$('#beneficiarioReg').html(response.fechaInscripcion);
			$('#beneficiarioTipo').html(response.nombreTipoBeneficiario);
			$('#fechaVencimiento').html(response.fechaVencimiento);
			$('#tiempoRes').html(response.tiempoRestante);
			$('#beneficiarioLocal').html(response.nombreLocalidad + ' - ' + response.nombreComite);
			$('#beneficiarioEstado').html(response.nombreEstadoBeneficiario);
			$('#beneficiarioParen').html(response.nombreTipoSocio);
			$('#beneficiarioSexo').html(response.sexoPostulante);
			if (response.idEstadoBenef == 1) {
				$('#tiempoRes, #beneficiarioEstado').removeClass('badge-danger');
	    		$('#tiempoRes, #beneficiarioEstado').addClass('badge-success');
			}else{
	    		$('#tiempoRes, #beneficiarioEstado').removeClass('badge-success');
				$('#tiempoRes, #beneficiarioEstado').addClass('badge-danger');
			}
			
		}
	});
});

$(document).on('click', '.editarBeneficiario', function(){
	$("#formEditarBenef")[0].reset();
	let idBeneficiario = $(this).attr('idBeneficiario');
	let idEstadoBenef = $(this).attr('idEstadoBenef'); 
	let datos = new FormData();
	datos.append("idBeneficiario", idBeneficiario);
	datos.append("idEstado", idEstadoBenef);
	datos.append("funcion", 'datosBeneficiario');
	$.ajax({
		url:"ajax/beneficiario.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success:function(response){
			$('#nombreBenef').html(response.apellidoPaternoPersona + ' ' + response.apellidoMaternoPersona + ', ' + response.nombrePersona);
			$('#dniBenef').html(response.dniPersona);
			$('#cmbParentesco').val(response['idTipoSocioBenef']);
			$('#cmbComite').val(response['idComiteBenef']);
			$('#cmbEstadoBenef').val(response.idEstadoBenef);
			$('textarea[name="txtDescripcionBenef"]').val(response['descripcionPostulante']); 
			$('input[name="idInscripcion"]').val(response['idInscripcionBenef']);
			$('input[name="idPostulante"]').val(response['idPostBenef']);
			$('input[name="fechaRg"]').val(response['fechaInscripcion']);
			$('input[name="fechaVen"]').val(response['fechaVencimiento']);
			$('input[name="estadoBen"]').val(response['idEstadoBenef']);
			if (response['sexoPostulante'] == 'FEMENINO') {
				$('input[name="customRadio"][value="F"]').prop("checked",true);
			}else if(response['sexoPostulante'] == 'MASCULINO'){
				$('input[name="customRadio"][value="M"]').prop("checked",true);
			}
			
		}
	});
});

$(document).on("submit", "#formEditarBenef", function(event){
	$.ajax({
		url:"ajax/beneficiario.ajax.php", 
		method: "POST",
		data: $('#formEditarBenef').serialize(),
		cache: false, 
		success:function(response){
			if (response == 'no') {
				alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', 'No es posible cambiar el estado, por que hay entrega de alimentos pendiente');
			}else if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡La accion se ejecuto con exito con exito!', 'success');
				$("#editarBeneficiario").modal('hide');
				if (btnVer == true) {
					verTabla();
				}else if(btnBuscar == true){
					verTablaFecha();
				}else{
					buscarEnTabla('tablaBeneficiarios', 'tablaBeneficiarios.ajax.php', '');
				}
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});

$(document).on("click", ".cambiarSocio", function(){
	$('input[name="idBeneficiario"]').val($(this).attr('idBeneficiario'));
	$('#formSocio')[0].reset(); 
});

$(document).on("click", "#btnBuscarSocio", function(){
	$('input[name="txtCorreoSocio"]').val(''); 
	$('input[name="txtCelularSocio"]').val(''); 
	let dni = $('input[name="txtDniSocio"]').val(); 
	if (dni.length == 8 && (/^\d{8}$/.test(dni))) {
		let datos = new FormData();
		datos.append('dniSocio', dni);
		datos.append('funcion', 'buscarDniSocio');
		$.ajax({
			url:"ajax/personas.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			success:function(response){
				$('#formSocio input[name="funcion"]').val('cambiarSocio'); 
			 	if (response == 'error') {
			 		$('input[name="idDireccionSocio"]').val('');	
					$('input[name="idPersonaSocio"]').val('');	
					$('input[name="idSocio"]').val('');	
					$('input[name="txtDireccionSocio"]').val(''); 
					$('input[name="txtNumeroDirSocio"]').val(''); 
					$('textarea[name="txtDescripcionDirSocio"]').val(''); 
					$('input[name="txtApellidoPaterno"]').removeAttr('readonly'); 
					$('input[name="txtApellidoMaterno"]').removeAttr('readonly'); 				
					$('input[name="txtNombreSocio"]').removeAttr('readonly'); 	
					activarInputModalSocio();
					alertas('alertaDniSocio1', '<i class="far fa-window-close"></i> No se encontró resultados');
				}else{
					if ((typeof response['idPersona'] == "undefined" || response['idPersona'] == null) && (typeof response['idPersonaSocio'] == "undefined" || response['idPersonaSocio'] == null)){
						$('input[name="idDireccionSocio"]').val('');	
						$('input[name="idPersonaSocio"]').val('');	
						$('input[name="idSocio"]').val('');	
						$('input[name="txtDireccionSocio"]').val(''); 
						$('input[name="txtNumeroDirSocio"]').val(''); 
						$('textarea[name="txtDescripcionDirSocio"]').val(''); 
						let respuesta = JSON.parse(response);
						if (respuesta.valor == 'vacio' || respuesta.name == '') {		
							$('input[name="txtApellidoPaterno"]').removeAttr('readonly'); 
							$('input[name="txtApellidoMaterno"]').removeAttr('readonly'); 				
							$('input[name="txtNombreSocio"]').removeAttr('readonly'); 	
							$('input[name="txtApellidoPaterno"]').val(''); 
							$('input[name="txtApellidoMaterno"]').val(''); 				
							$('input[name="txtNombreSocio"]').val(''); 		
							$('input[name="txtDireccionSocio"]').val(''); 
							$('input[name="txtNumeroDirSocio"]').val(''); 
							$('textarea[name="txtDescripcionDirSocio"]').val(''); 	
							activarInputModalSocio();	
							alertas('alertaDniSocio1', '<i class="fas fa-info-circle"></i> No se ha encontrado ningun resultado');
						}else{
							$('input[name="txtApellidoPaterno"]').val(respuesta.first_name); 
							$('input[name="txtApellidoMaterno"]').val(respuesta.last_name); 				
							$('input[name="txtNombreSocio"]').val(respuesta.name); 		
				 			$('input[name="txtApellidoPaterno"]').attr('readonly', 'readonly'); 
							$('input[name="txtApellidoMaterno"]').attr('readonly', 'readonly'); 				
							$('input[name="txtNombreSocio"]').attr('readonly', 'readonly'); 
							activarInputModalSocio();
						}
					}else{
						if (typeof response['idSocio'] == "undefined" || response['idSocio'] == null) {
							$('input[name="idSocio"]').val();
							$('input[name="idPersonaSocio"]').val(response['idPersona']);
							$('input[name="txtCelularSocio"]').removeAttr('readonly'); 
							$('input[name="txtCorreoSocio"]').removeAttr('readonly');
						}else{
							$('input[name="idSocio"]').val(response['idSocio']);
							$('input[name="txtCorreoSocio"]').val(response['correoSocio']); 
							$('input[name="txtCelularSocio"]').val(response['celular']); 
							$('input[name="idPersonaSocio"]').val(response['idPersonaSocio']);
							$('input[name="txtCelularSocio"]').attr('readonly', 'readonly'); 
							$('input[name="txtCorreoSocio"]').attr('readonly', 'readonly');
						}
						$('input[name="txtApellidoPaterno"]').val(response['apellidoPaternoPersona']); 
						$('input[name="txtApellidoMaterno"]').val(response['apellidoMaternoPersona']); 				
						$('input[name="txtNombreSocio"]').val(response['nombrePersona']); 
						$('input[name="txtApellidoPaterno"]').attr('readonly', 'readonly'); 
						$('input[name="txtApellidoMaterno"]').attr('readonly', 'readonly'); 				
						$('input[name="txtNombreSocio"]').attr('readonly', 'readonly'); 	
						$("#cmbDepartamentoSocio").find("option[value='']").remove();
						if (response['idDireccion'] != null) {
							$('input[name="idDireccionSocio"]').val(response['idDireccion']);
							$('#cmbDepartamentoSocio').val(response['idDepartamento']);
							let datos = new FormData();
							datos.append("idDepartamento", response['idDepartamento']);
							datos.append("funcion", 'mostrarProvincias');
							mostrarDatosCmb(datos, 'direccion.ajax.php', 'cmbProvinciaSocio', response['idProvincia']);
							let datos1 = new FormData();
							datos1.append("idProvincia", response['idProvincia']);
							datos1.append("funcion", 'mostrarDistritos');
							mostrarDatosCmb(datos1, 'direccion.ajax.php', 'cmbDistritoSocio', response['idDistrito']);
							$('input[name="txtDireccionSocio"]').val(response['nombreDireccion']); 
							$('input[name="txtNumeroDirSocio"]').val(response['numero']); 
							$('textarea[name="txtDescripcionDirSocio"]').val(response['descripcion']); 
							desactivarInputModalSocio();
						}else{
							activarInputModalSocio();
							$('input[name="idPersonaSocio"]').val(response['idPersona']);	
							$('input[name="idDireccionSocio"]').val('');	
							$('input[name="txtDireccionSocio"]').val(''); 
							$('input[name="txtNumeroDirSocio"]').val(''); 
							$('textarea[name="txtDescripcionDirSocio"]').val(''); 
						}
					}
				}

		    }
	  	});
	}else{
		alertas('alertaDniSocio', '<i class="far fa-window-close"></i> La busqueda no se ah realizado');
	}
}); 

$(document).on('submit', '#formSocio', function(event){
	$.ajax({
		url:"ajax/beneficiario.ajax.php",
		method: "POST",
		data: $('#formSocio').serialize(),
		cache: false,
		success:function(response){
			if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡El socio fue cambiado con exito!', 'success');
				if (btnVer == true) {
					verTabla();
				}else if(btnBuscar == true){
					verTablaFecha();
				}else{
					buscarEnTabla('tablaBeneficiarios', 'tablaBeneficiarios.ajax.php', '');
				}
				$("#formSocio")[0].reset();
				$("#cambiarSocio").modal('hide');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});
var btnVer = false;
var btnBuscar = false;

$(document).on("click", "#btnVerBeneficiarios", function(){
	btnVer = true;
	btnBuscar = false;
	verTabla();
});

$(document).on('click', '#btnBuscarFechas', function(){
	btnVer = false;
	btnBuscar = true;
	$('#cmbEstadoPostulantes').find("option[value='']").remove();
	verTablaFecha();
});

function verTabla(){
	let idLocalidad = $('#cmbLocalidadBenef').val();
	let idComite = $('#cmbComiteBenef').val();
	if (idLocalidad == 0) {
		buscarEnTabla('tablaBeneficiarios', 'tablaBeneficiarios.ajax.php', null);	
	}else if (idLocalidad > 0 && idComite > 0){
		let datos = new FormData();
		datos.append('funcion', 'buscarBenef');
		datos.append('valor', idComite);
		datos.append('item', 'idComiteBenef');
		datos.append('estado', 1);
		buscarEnTabla('tablaBeneficiarios', 'tablaBeneficiarios.ajax.php', datos);
		$('#cmbEstadoPostulantes').find("option[value='']").remove();
		$('#cmbEstadoPostulantes').val(1);
	}else{
		alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', 'La busqueda no es valida');	
	}
}

function verTablaFecha(){
	let idLocalidad = $('#cmbLocalidadBenef').val();
	let idComite = $('#cmbComiteBenef').val();
	let idEstado = $('#cmbEstadoPostulantes').val();
	let fechaInicio = $('input[name="dateFechaInicio"]').val();
	let fechaFin =  $('input[name="dateFechaFin"]').val();
	if (idEstado == '') {
		idEstado = 1;
	}
	let datos = new FormData();
	if ((idLocalidad == 0 || idLocalidad == '') && fechaInicio == '' && fechaFin == '') {
		datos.append('funcion', 'buscarBenefEstado');
		datos.append('estado', idEstado);
		buscarEnTabla('tablaBeneficiarios', 'tablaBeneficiarios.ajax.php', datos);
	}else if((idLocalidad == 0 || idLocalidad == '') && fechaInicio != '' && fechaFin != '') {
		datos.append('funcion', 'buscarBenefFecha');
		datos.append('estado', idEstado);
		datos.append('fechaInicio', fechaInicio);
		datos.append('fechaFin', fechaFin);
		buscarEnTabla('tablaBeneficiarios', 'tablaBeneficiarios.ajax.php', datos);
	}else if(idComite > 0 && fechaInicio == '' && fechaFin == ''){
		datos.append('funcion', 'buscarBenef');
		datos.append('valor', idComite);
		datos.append('item', 'idComiteBenef');
		datos.append('estado', idEstado);
		buscarEnTabla('tablaBeneficiarios', 'tablaBeneficiarios.ajax.php', datos);
	}else if (idComite > 0 && fechaInicio != '' && fechaFin != '') {
		datos.append('funcion', 'buscarFechaItem');
		datos.append('valor', idComite);
		datos.append('item', 'idComiteBenef');
		datos.append('estado', idEstado);
		datos.append('fechaInicio', fechaInicio);
		datos.append('fechaFin', fechaFin);
		buscarEnTabla('tablaBeneficiarios', 'tablaBeneficiarios.ajax.php', datos);
	}else{
		alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', 'La busqueda no es valida');	
	}
}




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
				$('input[name="txtPostulante"]').val(response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']+', '+response['nombrePersona']); 
				$('input[name="idPersona"]').val(idPersona); 
		    }
	  	});
	}
}

$(document).on("click", ".btnVencido", function(){
	let idBeneficiario = $(this).attr('idbeneficiario');
	let datos = new FormData();
	datos.append('idBeneficiario', idBeneficiario);
	datos.append('funcion', 'vencido');
	$.ajax({
		url:"ajax/beneficiario.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success:function(response){
			if (response == 'no') {
				alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', 'No es posible cambiar el estado, por que hay entrega de alimentos pendiente');
			}else if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡La accion se ejecuto con exito con exito!', 'success');
				if (btnVer == true) {
					verTabla();
				}else if(btnBuscar == true){
					verTablaFecha();
				}else{
					buscarEnTabla('tablaBeneficiarios', 'tablaBeneficiarios.ajax.php', '');
				}
				
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});

function limpiarDatosSocio(){
	$('#socioNombre').html('');
	$('#socioDni').html('');
	$('#socioUbicacion').html('');
	$('#socioDireccion').html('');
	$('#socioCelular').html('');
	$('#socioCorreo').html('');
}

function limpiarDatosPostulante(){
	$('#postulanteNombre').html('');
	$('#postulanteDni').html('');
	$('#fechaNacimiento').html('');
	$('#postulanteEdad').html('');
	$('#postulanteInscripcion').html('');
	$('#postulanteTipo').html('');
}

function activarInputModalSocio(){
	$('#cmbDepartamentoSocio').removeAttr('readonly');
	$('#cmbProvinciaSocio').removeAttr('readonly');
	$('#cmbDistritoSocio').removeAttr('readonly');
	$('input[name="txtDireccionSocio"]').removeAttr('readonly'); 
	$('input[name="txtNumeroDirSocio"]').removeAttr('readonly'); 
	$('textarea[name="txtDescripcionDirSocio"]').removeAttr('readonly'); 	
}

function desactivarInputModalSocio(){
	$('#cmbDepartamentoSocio').attr('readonly', 'readonly');
	$('#cmbProvinciaSocio').attr('readonly', 'readonly');
	$('#cmbDistritoSocio').attr('readonly', 'readonly');
	$('input[name="txtDireccionSocio"]').attr('readonly', 'readonly'); 
	$('input[name="txtNumeroDirSocio"]').attr('readonly', 'readonly'); 				
	$('textarea[name="txtDescripcionDirSocio"]').attr('readonly', 'readonly'); 
}