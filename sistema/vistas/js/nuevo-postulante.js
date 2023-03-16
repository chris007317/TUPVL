$(document).ready(function(){

	//	getFechaHora('dateFechaRegistro');
	udateTime();
	//$('#dateFechaRegistro').val(getFechaHora());
	$('.select2').select2();
	mostrarDataTable('tablaSocios', 'tablaSocios.ajax.php');
	limpiarFormPostulante();
	$('input[name="rdBtnSocio"][value="0"]').prop("checked", true);
	totalMeses = 0;
	valReg = false;
	$('#valReg').html('no valido');
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

$(document).on("click", "#btnAgregarSocio", function(){
	$("#formSocio")[0].reset();
	$('input[name="txtDireccionSocio"]').attr('readonly', 'readonly'); 
	$('input[name="txtNumeroDir"]').attr('readonly', 'readonly'); 				
	$('textarea[name="txtDescripcionDir"]').attr('readonly', 'readonly'); 
	$('input[name="txtApellidoPaterno"]').attr('readonly', 'readonly'); 
	$('input[name="txtApellidoMaterno"]').attr('readonly', 'readonly'); 				
	$('input[name="txtNombreSocio"]').attr('readonly', 'readonly'); 
});
/*----------  buscar socio  ----------*/
$(document).on("click", "#btnBuscarSocio", function(){
	$('input[name="txtCorreoSocio"]').val(''); 
	$('input[name="txtCelularSocio"]').val(''); 
	let dni = $('input[name="txtDniSocio"]').val(); 
	if (dni.length == 8 && (/^\d{8}$/.test(dni))) {
		let datos = new FormData();
		datos.append('dni', dni);
		datos.append('funcion', 'buscarDniDir');
		$.ajax({
			url:"ajax/personas.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			success:function(response){
				$('#formSocio input[name="funcion"]').val('agregarSocio'); 
			 	if (response == 'error') {
			 		$('input[name="idDireccionSocio"]').val('');	
					$('input[name="idPersonaSocio"]').val('');	
					$('input[name="txtDireccionSocio"]').val(''); 
					$('input[name="txtNumeroDir"]').val(''); 
					$('textarea[name="txtDescripcionDir"]').val(''); 
					$('input[name="txtApellidoPaterno"]').removeAttr('readonly'); 
					$('input[name="txtApellidoMaterno"]').removeAttr('readonly'); 				
					$('input[name="txtNombreSocio"]').removeAttr('readonly'); 	
					activarInputModalSocio();
					alertas('alertaDniSocio1', '<i class="far fa-window-close"></i> No se encontró resultados');
				}else{
					if (typeof response['idPersona'] == "undefined" || response['idPersona'] == null){
						$('input[name="idDireccionSocio"]').val('');	
						$('input[name="idPersonaSocio"]').val('');	
						$('input[name="txtDireccionSocio"]').val(''); 
						$('input[name="txtNumeroDir"]').val(''); 
						$('textarea[name="txtDescripcionDir"]').val(''); 
						let respuesta = JSON.parse(response);
						if (respuesta.valor == 'vacio' || respuesta.name == '') {		
							$('input[name="txtApellidoPaterno"]').removeAttr('readonly'); 
							$('input[name="txtApellidoMaterno"]').removeAttr('readonly'); 				
							$('input[name="txtNombreSocio"]').removeAttr('readonly'); 	
							$('input[name="txtApellidoPaterno"]').val(''); 
							$('input[name="txtApellidoMaterno"]').val(''); 				
							$('input[name="txtNombreSocio"]').val(''); 		
							$('input[name="txtDireccionSocio"]').val(''); 
							$('input[name="txtNumeroDir"]').val(''); 
							$('textarea[name="txtDescripcionDir"]').val(''); 	
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
						$('input[name="txtApellidoPaterno"]').val(response['apellidoPaternoPersona']); 
						$('input[name="txtApellidoMaterno"]').val(response['apellidoMaternoPersona']); 				
						$('input[name="txtNombreSocio"]').val(response['nombrePersona']); 
						$('input[name="idPersonaSocio"]').val(response['idPersona']);
						$('input[name="txtApellidoPaterno"]').attr('readonly', 'readonly'); 
						$('input[name="txtApellidoMaterno"]').attr('readonly', 'readonly'); 				
						$('input[name="txtNombreSocio"]').attr('readonly', 'readonly'); 	
						$("#cmbDepartamentoDir").find("option[value='']").remove();
						if (response['idDireccion'] != null) {
							$('input[name="idDireccionSocio"]').val(response['idDireccion']);
							$('#cmbDepartamentoDir').val(response['idDepartamento']);
							let datos = new FormData();
							datos.append("idDepartamento", response['idDepartamento']);
							datos.append("funcion", 'mostrarProvincias');
							mostrarDatosCmb(datos, 'direccion.ajax.php', 'cmbProvinciaDir', response['idProvincia']);
							let datos1 = new FormData();
							datos1.append("idProvincia", response['idProvincia']);
							datos1.append("funcion", 'mostrarDistritos');
							mostrarDatosCmb(datos1, 'direccion.ajax.php', 'cmbDistritoDir', response['idDistrito']);
							$('input[name="txtDireccionSocio"]').val(response['nombreDireccion']); 
							$('input[name="txtNumeroDir"]').val(response['numero']); 
							$('textarea[name="txtDescripcionDir"]').val(response['descripcion']); 
							desactivarInputModalSocio();
						}else{
							activarInputModalSocio();
							$('input[name="idPersonaSocio"]').val(response['idPersona']);	
							$('input[name="idDireccionSocio"]').val('');	
							$('input[name="txtDireccionSocio"]').val(''); 
							$('input[name="txtNumeroDir"]').val(''); 
							$('textarea[name="txtDescripcionDir"]').val(''); 
						}
					}
				}
		    }
	  	});
	}else{
		alertas('alertaDniSocio', '<i class="far fa-window-close"></i> La busqueda no se ah realizado');
	}
}); 
/*----------  enviar datos  ----------*/
$(document).on('submit', '#formSocio', function(event){
	$.ajax({
		url:"ajax/socio.ajax.php",
		method: "POST",
		data: $('#formSocio').serialize(),
		cache: false,
		success:function(response){
			if (response == 'existe') {
				mensaje('¡Existe!', '¡El socio ya se encuentra registrado!', 'warning');
			}else if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡La accion se ejecuto con exito con exito!', 'success');
				buscarEnTabla('tablaSocios', 'tablaSocios.ajax.php', null);	
				$("#formSocio")[0].reset();
				$("#modalSocio").modal('hide');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});

$(document).on('click', '.btnElegirSocio', function(){
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
			$('#nombreSocio').html(response.apellidoPaternoPersona + ' ' + response.apellidoMaternoPersona + ', ' + response.nombrePersona);
			$('#dniSocio').html(response.dniPersona);
			$('#ubicacionSocio').html(response.nombreDepartamento + ', ' + response.nombreProvincia + ', ' + response.nombreDistrito);
			$('#direccionSocio').html(response.nombreDireccion + ' N° ' + response.numero);
			$('#celularSocio').html(response.celular);
			$('#correoSocio').html(response.correoSocio);
			$('#rdBtnSi').val(response.idPersonaSocio);
			$("#verSocios").modal('hide');
			$('input[name="idSocioPostulante"]').val(idSocio);
			$('input[name="rdBtnSocio"][value="0"]').prop("checked", true);
		}
	});
});

$(document).on('click', '#btnLimpiarSocio', function(){
	if ($('input[name="txtDniPostulante"]').val() == $('#dniSocio').html()) {
		limpiarFormPostulante();
	}
	limpiarDatosSocio();
	$('input[name="rdBtnSocio"][value="0"]').prop("checked", true);
});

$(document).on('change', 'input[name="rdBtnSocio"]', function(){
	let valor = $(this).val();
	if (valor > 0) {
		limpiarFormPostulante();
		let datos = new FormData();
		datos.append('idPersona', valor);
		datos.append('funcion', 'buscarIdDir');
		$.ajax({
			url:"ajax/personas.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			success:function(response){
				if (typeof response['dniPersona'] != "undefined" ) {
					$('#formPostulante input[name="txtDniPostulante"]').val(response['dniPersona']);
					$('#formPostulante input[name="txtApellidoPaternoPost"]').val(response['apellidoPaternoPersona']);
					$('#formPostulante input[name="txtApellidoMaternoPost"]').val(response['apellidoMaternoPersona']);
					$('#formPostulante input[name="txtNombresPost"]').val(response['nombrePersona']);
					//$('#formPostulante input[name="txtNombresPost"]').val(response['nombrePersona']);
					$("#cmbDepartamentoPost").find("option[value='']").remove();
					$('#cmbDepartamentoPost').val(response['idDepartamento']);
					let datos = new FormData();
					datos.append("idDepartamento", response['idDepartamento']);
					datos.append("funcion", 'mostrarProvincias');
					mostrarDatosCmb(datos, 'direccion.ajax.php', 'cmbProvinciaPost', response['idProvincia']);
					let datos1 = new FormData();
					datos1.append("idProvincia", response['idProvincia']);
					datos1.append("funcion", 'mostrarDistritos');
					mostrarDatosCmb(datos1, 'direccion.ajax.php', 'cmbDistritoPost', response['idDistrito']);
					$('#formPostulante input[name="txtDireccionPostulante"]').val(response['nombreDireccion']);
					$('#formPostulante input[name="txtNumeroDirPostulante"]').val(response['numero']);
					$('#formPostulante input[name="txtDescripcionDirPost"]').val(response['descripcion']);
					desactivarInputPostulante();
					if (typeof response['idPostulante'] == "undefined" || response['idPostulante'] == null) {
						$('input[name="dateFechaNac"]').removeAttr('readonly'); 		
					}else{
						$('input[name="idPost"]').val(response['idPostulante']);
						$('input[name="dateFechaNac"]').val(response['fechaNacimiento']);
						$('input[name="dateFechaNac"]').change();
						if (response['sexoPostulante'] == 'FEMENINO') {
							$('input[name="customRadio"][value="F"]').prop("checked",true);
						}else if(response['sexoPostulante'] == 'MASCULINO'){
							$('input[name="customRadio"][value="M"]').prop("checked",true);
						}
					}
				}else{
					respuesta = JSON.parse(response);
					if (respuesta.valor == 'existe'){
						mensaje('¡Error!', '¡El beneficiario ya se encuentra registrado!', 'error');
					}
				}
		    }
	  	});
	}else{
		limpiarFormPostulante();	
		$('input[name="idPersonaPostulante"]').val(''); 
		$('input[name="idDireccionPostulante"]').val(''); 
		$('input[name="idPost"]').val(''); 
	}
});

$(document).on('change', '#cmbDepartamentoPost', function(){
	idDepartamento = $(this).val();
	$(this).find("option[value='']").remove();
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
	    	$('#cmbProvinciaPost').html(template);
	    	$('#cmbProvinciaPost').attr('disabled', false);
			idProvincia = $('#cmbProvinciaPost').val();
			let datos1 = new FormData();
			datos1.append("idProvincia", idProvincia);
			datos1.append("funcion", 'mostrarDistritos');
			mostrarDatosCmb(datos1, 'direccion.ajax.php', 'cmbDistritoPost', 0);
	    }
  	});
});

$(document).on('change', '#cmbProvinciaPost', function(){
	idProvincia = $(this).val();
	let funcion = 'mostrarDistritos';
	let datos = new FormData();
	datos.append("idProvincia", idProvincia);
	datos.append("funcion", funcion);
	mostrarDatosCmb(datos, 'direccion.ajax.php', 'cmbDistritoPost');
});

$(document).on('change', '#cmbTipoLocalidadPost', function(){
	idLocalidad = $(this).val();
	$(this).find("option[value='']").remove();
	let funcion = 'mostrarComites';
	let datos = new FormData();
	datos.append("idLocalidad", idLocalidad);
	datos.append("funcion", funcion);
	mostrarDatosCmb(datos, 'comite.ajax.php', 'cmbComitesPost');
});

$(document).on('change', '#cmbTipoPostulante', function(){
	$(this).find("option[value='']").remove();
	idTipoPost = $(this).val();
	edadInicio = $(this).find("option[value='"+idTipoPost+"']").attr('inicioEdad');
	edadFin = $(this).find("option[value='"+idTipoPost+"']").attr('finEdad');
	if (idTipoPost > 0) {
		let datos = new FormData();
		datos.append("idTipoBeneficiario", idTipoPost);
		datos.append("funcion", 'mostrarTipoBenefRequisitos');
		validarEdad(totalMeses, edadInicio, edadFin);
		requisitoSpan(0, 0, 'numRequisitos');
		$('#totalRequisitos').html(0);
		$('input[name="totalReq"]').val(0);
		$('#requisitos').html('');
		if (valReg == true) {
			$.ajax({
				url:"ajax/requisito-municipalidad.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
			    success:function(response){
			    	let total = 0
			    	let template = '';
			    	response.forEach(valor =>{
			    		if (valor.estado == 1) {
			    			total = total + 1;
							template +=`
								<div class="custom-control custom-checkbox">
		                          <input class="custom-control-input checkRequisito" type="checkbox" id="checkRequisto${total}" name="checkRequisto${total}" value="${valor.idReMuni}">
		                          <label for="checkRequisto${total}" class="custom-control-label">${valor.nombreRequisito}</label>
		                        </div>
							`;
			    		}
			    		$('#requisitos').html(template);
			    		$('#totalRequisitos').html(total);
			    		totalRequisito = total;
			    		contarRequisitos = 0;
			    		$('input[name="totalReq"]').val(totalRequisito);
			    		requisitoSpan(0, totalRequisito, 'numRequisitos');
			    	});
			    }
		  	});
		}
	}
});

$(document).on('change', '.checkRequisito', function(){
	if($(this).prop('checked')){
		contarRequisitos = contarRequisitos + 1; 
		requisitoSpan(contarRequisitos, totalRequisito, 'numRequisitos');
	}else{
		contarRequisitos = contarRequisitos - 1;
		requisitoSpan(contarRequisitos, totalRequisito, 'numRequisitos');
	}
});

$(document).on('change', 'input[name="dateFechaNac"]', function(){
	let fecha = $(this).val();
  	let a = new Date(fecha).getFullYear();
  	if (a > 1900) {
		let datos = new FormData();
		datos.append("fechaNacimiento", fecha);
		datos.append("funcion", 'calcularFecha');
		$.ajax({
			url:"ajax/personas.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
		    success:function(response){
		    	if (response == 'error') {
		    		mensaje('¡Error!', '¡Ingresar una fecha de nacimuento valida!', 'error');
		    	}else{
		    		respuesta = JSON.parse(response);
		    		darFecha(respuesta.y, respuesta.m, respuesta.d, 'edadPostulante');
		    		totalMeses = (respuesta.y * 12) + respuesta.m;
	  				validarEdad(totalMeses, edadInicio, edadFin);
		    	}
		    }
	  	});
  	}
});

$(document).on("click", "#buscarPostulante", function(){
	let dni = $('input[name="txtDniPostulante"]').val(); 
	if (dni.length == 8 && (/^\d{8}$/.test(dni))) {
		let datos = new FormData();
		datos.append('dni', dni);
		datos.append('funcion', 'buscarDniPostulante');
		$.ajax({
			url:"ajax/personas.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			success:function(response){
			 	if (response == 'error') {
					mensaje('¡Error!', '¡Ocurrio un error al realizar la busqueda!', 'error');
					$('input[name="dateFechaNac"]').removeAttr('readonly');
					$('input[name="txtApellidoPaternoPost"]').removeAttr('readonly'); 
					$('input[name="txtApellidoMaternoPost"]').removeAttr('readonly'); 				
					$('input[name="txtNombresPost"]').removeAttr('readonly'); 	
					$('input[name="txtApellidoPaternoPost"]').val(''); 
					$('input[name="txtApellidoMaternoPost"]').val(''); 				
					$('input[name="txtNombresPost"]').val(''); 
				}else{
					if (typeof response['idPersona'] == "undefined" || response['idPersona'] == null){
						$('input[name="idPersonaPostulante"]').val('');	
						$('input[name="idDireccionPostulante"]').val('');	
						$('input[name="idPost"]').val('');	
						$('input[name="txtApellidoPaternoPost"]').val(''); 
						$('input[name="txtApellidoMaternoPost"]').val(''); 				
						$('input[name="txtNombresPost"]').val(''); 		
						$('input[name="txtDireccionPostulante"]').val(''); 
						$('input[name="txtNumeroDirPostulante"]').val(''); 
						$('textarea[name="txtDescripcionDirPost"]').val(''); 
						$('input[name="dateFechaNac"]').val('');
						let respuesta = JSON.parse(response);
						if (respuesta.valor == 'existe') {
							mensaje('¡Advertencia!', '¡El beneficiario ya se encuentra registrado!', 'warning');		
						}else if (respuesta.valor == 'vacio' || respuesta.name == '') {		
							$('input[name="dateFechaNac"]').removeAttr('readonly');
							$('input[name="txtApellidoPaternoPost"]').removeAttr('readonly'); 
							$('input[name="txtApellidoMaternoPost"]').removeAttr('readonly'); 				
							$('input[name="txtNombresPost"]').removeAttr('readonly'); 	
							$('input[name="txtApellidoPaternoPost"]').val(''); 
							$('input[name="txtApellidoMaternoPost"]').val(''); 				
							$('input[name="txtNombresPost"]').val(''); 			
							mensaje('¡Advertencia!', '¡No se econtraron resultados al realizar la busqueda, rellanar los datos de forma manual!', 'warning');
						}else{
							$('input[name="txtApellidoPaternoPost"]').val(respuesta.first_name); 
							$('input[name="txtApellidoMaternoPost"]').val(respuesta.last_name); 				
							$('input[name="txtNombresPost"]').val(respuesta.name); 		
				 			$('input[name="txtApellidoPaternoPost"]').attr('readonly', 'readonly'); 
							$('input[name="txtApellidoMaternoPost"]').attr('readonly', 'readonly'); 				
							$('input[name="txtNombresPost"]').attr('readonly', 'readonly'); 
							$('input[name="dateFechaNac"]').removeAttr('readonly');
						}
					}else{
						$('input[name="txtApellidoPaternoPost"]').val(response['apellidoPaternoPersona']); 
						$('input[name="txtApellidoMaternoPost"]').val(response['apellidoMaternoPersona']); 				
						$('input[name="txtNombresPost"]').val(response['nombrePersona']); 
						$('input[name="idPersonaPostulante"]').val(response['idPersona']);
						$('input[name="txtApellidoPaternoPost"]').attr('readonly', 'readonly'); 
						$('input[name="txtApellidoMaternoPost"]').attr('readonly', 'readonly'); 				
						$('input[name="txtNombresPost"]').attr('readonly', 'readonly'); 	
						if (response['idDireccion'] != null) {
							$("#cmbDepartamentoPost").find("option[value='']").remove();
							$('input[name="idDireccionPostulante"]').val(response['idDireccion']);
							$('#cmbDepartamentoPost').val(response['idDepartamento']);
							let datos = new FormData();
							datos.append("idDepartamento", response['idDepartamento']);
							datos.append("funcion", 'mostrarProvincias');
							mostrarDatosCmb(datos, 'direccion.ajax.php', 'cmbProvinciaPost', response['idProvincia']);
							let datos1 = new FormData();
							datos1.append("idProvincia", response['idProvincia']);
							datos1.append("funcion", 'mostrarDistritos');
							mostrarDatosCmb(datos1, 'direccion.ajax.php', 'cmbDistritoPost', response['idDistrito']);
							$('input[name="txtDireccionPostulante"]').val(response['nombreDireccion']); 
							$('input[name="txtNumeroDirPostulante"]').val(response['numero']); 
							$('textarea[name="txtDescripcionDirPost"]').val(response['descripcion']); 
						}
						if (typeof response['idPostulante'] == "undefined" || response['idPostulante'] == null) {
							$('input[name="dateFechaNac"]').removeAttr('readonly'); 		
							$('input[name="dateFechaNac"]').val(''); 		
							$('#edadPostulante').html('');
						}else{
							$('input[name="idPost"]').val(response['idPostulante']);
							$('input[name="dateFechaNac"]').val(response['fechaNacimiento']);
							$('input[name="dateFechaNac"]').change();
							if (response['sexoPostulante'] == 'FEMENINO') {
								$('input[name="customRadio"][value="F"]').prop("checked",true);
							}else if(response['sexoPostulante'] == 'MASCULINO'){
								$('input[name="customRadio"][value="M"]').prop("checked",true);
							}
						}
					}
				}

		    }
	  	});
	}
});

/*----------  enviar datos  ----------*/
$(document).on('click', '#btnRegistrarPostulante', function(event){
	if (!$('input[name="customRadio"]').is(':checked')) {
		mensaje('¡Advertencia!', '¡No se ha selecionado el sexo del postulante!', 'warning');
		event.preventDefault();
	}else if ($('input[name="idSocioPostulante"]').val() == '') {
		mensaje('¡Advertencia!', '¡No se ha selecionado el socio del postulante!', 'warning');
		event.preventDefault();
	}else if (valReg == false) {
		mensaje('¡Advertencia!', '¡El postulante no cumple con la edad requerida para el tipo de beneficiario!', 'warning');
		event.preventDefault();
	}
});

$(document).on('click', '#btnCancelarPost', function(event){
	limpiarFormPostulante();
	limpiarDatosSocio();
	$('input[name="idPersonaPostulante"]').val(''); 
	$('input[name="idDireccionPostulante"]').val(''); 
	$('input[name="idPost"]').val(''); 
	contarRequisitos = 0;
	totalMeses = 0;
	valReg = false;
	$('#valReg').html('no valido');
	requisitoSpan(contarRequisitos, totalRequisito, 'numRequisitos');
});

function activarInputModalSocio(){
	$('#cmbDepartamentoDir').removeAttr('readonly');
	$('#cmbProvinciaDir').removeAttr('readonly');
	$('#cmbDistritoDir').removeAttr('readonly');
	$('input[name="txtDireccionSocio"]').removeAttr('readonly'); 
	$('input[name="txtNumeroDir"]').removeAttr('readonly'); 
	$('textarea[name="txtDescripcionDir"]').removeAttr('readonly'); 	
}

function desactivarInputModalSocio(){
	$('#cmbDepartamentoDir').attr('readonly', 'readonly');
	$('#cmbProvinciaDir').attr('readonly', 'readonly');
	$('#cmbDistritoDir').attr('readonly', 'readonly');
	$('input[name="txtDireccionSocio"]').attr('readonly', 'readonly'); 
	$('input[name="txtNumeroDir"]').attr('readonly', 'readonly'); 				
	$('textarea[name="txtDescripcionDir"]').attr('readonly', 'readonly'); 
}

function activarInputModalSocio(){
	$('#cmbDepartamentoDir').removeAttr('readonly');
	$('#cmbProvinciaDir').removeAttr('readonly');
	$('#cmbDistritoDir').removeAttr('readonly');
	$('input[name="txtDireccionSocio"]').removeAttr('readonly'); 
	$('input[name="txtNumeroDir"]').removeAttr('readonly'); 
	$('textarea[name="txtDescripcionDir"]').removeAttr('readonly'); 	
}

function desactivarInputPostulante(){
	$('input[name="txtApellidoPaternoPost"]').attr('readonly', 'readonly'); 
	$('input[name="txtApellidoMaternoPost"]').attr('readonly', 'readonly'); 				
	$('input[name="txtNombresPost"]').attr('readonly', 'readonly'); 
}

function limpiarDatosSocio(){
	$('#nombreSocio').html('');
	$('#dniSocio').html('');
	$('#ubicacionSocio').html('');
	$('#direccionSocio').html('');
	$('#celularSocio').html('');
	$('#correoSocio').html('');
	$('#rdBtnSi').val('');
	$('input[name="idSocioPostulante"]').val(''); 
}


var udateTime = function (){
	let fechaHora = new Date();
	segundo = fechaHora.getSeconds(),
	minuto = fechaHora.getMinutes();
	hora = fechaHora.getHours();
	dia = fechaHora.getDate();
	mes = fechaHora.getMonth();
	año = fechaHora.getFullYear();
	fechaActual = año+'-'+verCero(mes+1)+'-'+verCero(dia)+'T'+verCero(hora)+':'+verCero(minuto)+':'+verCero(segundo);
	$('#dateFechaRegistro').val(fechaActual);
	$('#dateFechaRegistro').attr('max', fechaActual);
	setTimeout(udateTime,1000)  
}

var contarRequisitos = 0;	
var totalRequisito = 0;
var totalMeses = 0;
var edadInicio = 0;
var edadFin = 0;
var valReg = false;

function requisitoSpan(contar, total, elemento){
	$('#'+elemento).html(contar + ' requisitos de '+total);
}

function darFecha(año, mes, dias, elemento){
	if (mes == 0 && dias == 0) {
		$('#'+elemento).html(año + ' años ');
	}else if (dias == 0) {
		$('#'+elemento).html(año + ' años ' + mes + ' meses');
	}else if(mes == 0){
		$('#'+elemento).html(año + ' años ' + dias + ' días');
	}else{
		$('#'+elemento).html(año + ' años ' + mes + ' meses ' + dias + ' días');
	}
}

function limpiarFormPostulante(){
	$("#formPostulante")[0].reset();
}

function validarEdad(edadMes, inicioEdad, finEdad){
	let valor = $('#cmbTipoPostulante').find("option[value='']").val();
	if (edadMes > 0 && valor != '') {
		if (edadMes > inicioEdad && (edadMes < finEdad || finEdad == 0)) {
			$('#valReg').html('valido');
			$('#valReg').removeClass('badge-danger');
			$('#valReg').addClass('badge-info');
			valReg = true;
		}else{
			$('#valReg').html('no valido');
			$('#valReg').removeClass('badge-info');
			$('#valReg').addClass('badge-danger');
			valReg = false;
		}
	}
}