$(document).ready(function(){
	mostrarDataTable('tablaPostulantes', 'tablaPostulantes.ajax.php');
	$('.select2').select2();
	porcentaje();
});

$(document).on("click", "#btnBuscarFechas", function(){
	let fechaInicio = $('input[name="dateFechaInicio"]').val();
	let fechaFin =  $('input[name="dateFechaFin"]').val();
	let estado = $('#cmbEstadoPostulantes').val();
	if (fechaInicio != '' && fechaFin  != '' && estado != '') {
		let valor = compararFechas(fechaInicio, fechaFin);
		if (valor == 2 || valor == 3) {
			let datos = new FormData();
			datos.append('funcion', 'buscarPostFecha');
			datos.append('fechaIncicio', fechaInicio);
			datos.append('fechaFin', fechaFin);
			datos.append('estado', estado);
			buscarEnTabla('tablaPostulantes', 'tablaPostulantes.ajax.php', datos);
		}else if (valor == 1) {
			alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', 'Las fechas ingresadas no son validas');	
		}
	}else if (fechaInicio == '' && fechaFin  == '' && estado != '') {
		let datos = new FormData();
		datos.append('funcion', 'buscarPostEstado');
		datos.append('estado', estado);
		console.log("estado", estado);
		buscarEnTabla('tablaPostulantes', 'tablaPostulantes.ajax.php', datos);
	}else{
		alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', 'No se seleccionaron las fechas');	
	}
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

$(document).on('change', '#cmbLocalidad', function(){
	idLocalidad = $(this).val();
	let funcion = 'mostrarComites';
	let datos = new FormData();
	datos.append("idLocalidad", idLocalidad);
	datos.append("funcion", funcion);
	mostrarDatosCmb(datos, 'comite.ajax.php', 'cmbComite');
});


$(document).on('click', '.editarDireccion', function(){
	$("#formDireccion")[0].reset();
	$('#modalDireccion h4').html('Editar dirección');
	$('#formDireccion button[type="submit"]').html('Guardar'); 
	let idPersona = $(this).attr('idPersona');
	let idDireccion = $(this).attr('idDireccion');
	$('input[name="idDireccion"]').val(idDireccion); 
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
				buscarEnTabla('tablaPostulantes', 'tablaPostulantes.ajax.php', '');
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

$(document).on('click', '.editarPostulante', function(){
	limpiarDatosSocio();
	let idInscripcion = $(this).attr('idInscripcion');
	let datos = new FormData();
	limpiarDatosPostulante();
	datos.append("idInscripcion", idInscripcion);
	datos.append("funcion", 'buscarPostulanteInscripcion');
	$.ajax({
		url:"ajax/personas.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success:function(response){
			$('#postulanteNombre').html(response.apellidoPaternoPersona + ' ' + response.apellidoMaternoPersona + ', ' + response.nombrePersona);
			$('#postulanteDni').html(response.dniPersona);
			$('#fechaNacimiento').html(response.fechaNacimiento);
			$('#postulanteEdad').html(response.edadPostulante);
			$('#postulanteInscripcion').html(response.fechaInscripcion + ' ' + response.horaRegistro);
			$('#postulanteTipo').html(response.nombreTipoBeneficiario);
			if (response.estadoInscripcion == 1) {
				$('#postulanteEstado').html('Recibido');
			}
			$('#cmbLocalidad').val(response['idLocalidadComite']);
			let datos = new FormData();
			datos.append("idLocalidad", response['idLocalidadComite']);
			datos.append("funcion", 'mostrarComites');
			mostrarDatosCmb(datos, 'comite.ajax.php', 'cmbComite', response['idComiteInscripcion']);
			$('textarea[name="txtDescripcionPost"]').val(response['descripcionPostulante']);
			$('input[name="idPostulante"]').val(response['idPostulante']);
			$('input[name="idInscripcion"]').val(response['idInscripcion']);
			if (response['sexoPostulante'] == 'FEMENINO') {
				$('input[name="customRadio"][value="F"]').prop("checked",true);
			}else if(response['sexoPostulante'] == 'MASCULINO'){
				$('input[name="customRadio"][value="M"]').prop("checked",true);
			}
		} 
	});
});

$(document).on('submit', '#formPostulante', function(event){
	$.ajax({
		url:"ajax/postulante.ajax.php",
		method: "POST",
		data: $('#formPostulante').serialize(),
		cache: false,
		success:function(response){
			if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡La accion se ejecuto con exito con exito!', 'success');
				buscarEnTabla('tablaPostulantes', 'tablaPostulantes.ajax.php', '');
				$("#formPostulante")[0].reset();
				$("#modalPostulante").modal('hide');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});

$(document).on('click', '.accionPostulante', function(){
	idPostulante = $(this).attr('idPostulante');
	idInscripcion = $(this).attr('idInscripcion');
	idTipoInscripcion = $(this).attr('tipoPost');
	totalRequisito = 0;
	contarRequisito = 0;
	estadoPost = 0;
	let funcion = 'mostrarInscripcionPost';
	let datos = new FormData();
	datos.append("idPostulante", idPostulante);
	datos.append("idInscripcion", idInscripcion);
	datos.append("idTipoInscripcion", idTipoInscripcion);
	datos.append("funcion", funcion);
	$.ajax({
		url:"ajax/postulante.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
	    success:function(response){ 
	    	$('#nombrePost').html(response.apellidoPaternoPersona + ' ' + response.apellidoMaternoPersona + ', ' + response.nombrePersona);
			$('#dniPost').html(response.dniPersona);
			$('#fechaNacPost').html(response.fechaNacimiento);
			$('#edadPost').html(response.edadPostulante);
			$('#tipoPost').html(response.nombreTipoBeneficiario);
	    	$('#listaReq').html(response.reqList);
	    	if (response.finEdad >= response.edadMeses || response.finEdad == 0) {
	    		$('#estadoPost').html('Habilitado');
	    		estadoPost = 1;
	    		$('#estadoPost').removeClass('badge-danger');
	    		$('#estadoPost').addClass('badge-success');
	    		$("#btnAprobarPost").show();
	    		$('input[name="mesesMaximo"]').val(response.tiempoMeses); 
	    	}else{
	    		$('#estadoPost').html('Inhabilitado');
	    		estadoPost = 0;
	    		$('#estadoPost').removeClass('badge-success');
	    		$('#estadoPost').addClass('badge-danger');
	    		$("#btnAprobarPost").hide();
	    	}
	    	if (response.idTipoInscripcion == 1 || response.idTipoInscripcion == 4) {
	    		$('#listaPost li:eq(8)').remove();
	    		$('#listaPost').append(`
	    			<li class="list-group-item d-sm-flex madre">
                		<div class="form-group col-md-6">
                  			<label>Meses</label>
                  			<input type="number" class="form-control" name="txtMeses">
                		</div>
                		<div class="form-group col-md-6">
                  			<label>Días</label>
                  			<input type="number" class="form-control" name="txtDias">
                		</div>
              		</li>`);
	    	}else{
	    		$('#listaPost li:eq(8)').remove();
	    	}
	    	$('input[name="idPost"]').val(idPostulante);
			$('input[name="idIns"]').val(idInscripcion);
	    	totalRequisito = response.totalRequisitos;
	    	contarRequisito = response.contarRequisito;
	    	requisitoSpan(contarRequisito, totalRequisito, 'numRequisitos');
	    	udateTime();
	    }
  	});

});

$(document).on('change', '.checkRequisito', function(){
	if($(this).prop('checked')){
		contarRequisito = contarRequisito + 1; 
		requisitoSpan(contarRequisito, totalRequisito, 'numRequisitos');
	}else{
		contarRequisito = contarRequisito - 1;
		requisitoSpan(contarRequisito, totalRequisito, 'numRequisitos');
	}
});

$(document).on("submit", "#formAccion", function(event){
	limpiarImputHidden();
	if (contarRequisito == totalRequisito) {
		if (estadoPost == 1) {
			$('input[name="totalReq"]').val(totalRequisito);
			$('input[name="fechaReg"]').val($('#fechaReg').html());
			$('input[name="fechaNacPost"]').val($('#fechaNacPost').html());
			$.ajax({
				url:"ajax/postulante.ajax.php",
				method: "POST",
				data: $('#formAccion').serialize(),
				cache: false, 
				success:function(response){
					if (response == 'existe') {
						alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', '¡El beneficiario ya se encuentra registrado!');	
					}else if(response == 'noval'){
						alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', '¡El tiempo para ser beneficiario sobrepasa la fecha actual!');	
					}else if(response == 'no'){
						alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', '¡No se puede agregar beneficiario por tener entrega de alimentos pendientes!');	
					}else if(response == 'ok'){
						$("#modalAccionPostulante").modal('hide');
						mensaje('¡CORRECTO!', '¡La accion se ejecuto con exito con exito!', 'success');
						buscarEnTabla('tablaPostulantes', 'tablaPostulantes.ajax.php', '');
						$("#formAccion")[0].reset();
						$('#cmbEstadoPostulantes').val(1);
						$('input[name="dateFechaInicio"]').val('');
						$('input[name="dateFechaFin"]').val('');
						porcentaje();
						$("#modalAccionPostulante").modal('hide');
					}else if(response == 'novalido'){
						alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', '¡La edad sobrepasa la soportada por el tipo de beneficiario!');	
					}else{
						mensaje('¡Error!', '¡Ocurrio un error al realizar el registro! Comuniquese con el administrador', 'error');
					}
			    }
		  	});
		}else{
			alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', '¡El postulante paso la edad permitida!');		
		}
	}else{
		alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', '¡El postulante no comple los requisitos!');	
	}
	event.preventDefault();
});

$(document).on('click', '#btnRechazarPost', function(){
	let idInscripcion = $('input[name="idIns"]').val();
	let datos = new FormData();
	datos.append("idInscripcion", idInscripcion);
	datos.append("funcion", 'editarEstado');
	datos.append("estado", 0);
	$.ajax({
		url:"ajax/postulante.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success:function(response){
			if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡La accion se ejecuto con exito con exito!', 'success');
				buscarEnTabla('tablaPostulantes', 'tablaPostulantes.ajax.php', '');
				porcentaje();
				$("#modalAccionPostulante").modal('hide');
			}else{
				mensaje('¡Error!', '¡Ocurrio un error al realizar la acción! Comuniquese con el administrador', 'error');
			}
	    }
  	});
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
				$('input[name="txtPostulante"]').val(response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']+', '+response['nombrePersona']); 
				$('input[name="idPersona"]').val(idPersona); 
		    }
	  	});
	}
}

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

function requisitoSpan(contar, total, elemento){
	$('#'+elemento).html(contar + ' requisitos de '+total);
}

var totalRequisito = 0;
var contarRequisito = 0;
var estadoPost = 0;

var udateTime = function (){
	let fechaHora = new Date();
	segundo = fechaHora.getSeconds(),
	minuto = fechaHora.getMinutes();
	hora = fechaHora.getHours();
	dia = fechaHora.getDate();
	mes = fechaHora.getMonth();
	año = fechaHora.getFullYear();
	fechaActual = año+'-'+verCero(mes+1)+'-'+verCero(dia)+' '+verCero(hora)+':'+verCero(minuto)+':'+verCero(segundo);
	$('#fechaReg').html(fechaActual);
	setTimeout(udateTime,1000)  
}

function porcentaje(){
	let datos = new FormData();
	datos.append('funcion', 'contar');
	datos.append('estado', 2);
	barraProgreso('postulante.ajax.php', datos, 'activos', 'porcentaje');
	let datos1 = new FormData();
	datos1.append('funcion', 'contar');
	datos1.append('estado', 0);
	barraProgreso('postulante.ajax.php', datos1, 'rechazado', 'porcentajes');
}

function limpiarImputHidden(){
	$('input[name="totalReq"]').val('');
	$('input[name="fechaReg"]').val('');
	$('input[name="fechaNacPost"]').val('');
}