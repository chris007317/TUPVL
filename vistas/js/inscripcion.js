/*----------  comboBox Provincias  ----------*/
var rutaDominio = "https://www.tupvl.com";
$(document).ready(function (event){
	$('#cmbDepartamentos').change(function(event){
		let idDepartamento = $(this).val();
		let funcion = 'mostrarProvincias';
		let datos = new FormData();
		let template = '';
		datos.append("idDepartamento", idDepartamento);
		datos.append("funcion", funcion);
		$("#cmbDepartamentos").find("option[value='']").remove();
  		$.ajax({
			url:"ajax/inscripcion.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			    success:function(response){
			    	response.forEach(valor =>{
						template +=`
							<option value="${valor.idProvincia}">${valor.nombreProvincia}</option>
						`;
			    	});
			    	$('#cmbProvincias').html(template);
			    	$('#cmbProvincias').attr('disabled', false);
			    	let idProvincia = $('#cmbProvincias').val();
			    	mostrarDistritos(idProvincia);
			    }
	  	});
	});
	/*----------  mostrar distritos  ----------*/
	$('#cmbProvincias').change(function(event){
		let idProvincia = $(this).val();
		mostrarDistritos(idProvincia);
	});
	/*----------  mostrar datos con DNI  ----------*/
	$('#txtDniResponsable').keyup(function(event){
		let dni = $(this).val();
		if (dni.length==8) {
			let datos = new FormData();
			datos.append('dni', $(this).val());
			datos.append('funcion', 'buscarDni');
			$.ajax({
				url:"ajax/inscripcion.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success:function(response){
			    	if (response=='error') {
			    		$('#txtDniResponsable').val('');
			    		alert('¡El número de DNI: '+dni+' no fue econtrado! Vuelva a intentarlo.');
			    		return;
			    	}else{
			    		let datosPersona = JSON.parse(response);
			    		$('#txtApellidoPaterno').val(datosPersona.first_name);
			    		$('#txtApellidoMaterno').val(datosPersona.last_name);
			    		$('#txtNombres').val(datosPersona.name);
			    	}
				    }
		  	});
		}else{
    		$('#txtApellidoPaterno').val('');
    		$('#txtApellidoMaterno').val('');
    		$('#txtNombres').val('');
		}
	});
	/*----------  Mostrar datos muni  ----------*/	
	$('#txtRuc').keyup(function(event){
		let ruc = $(this).val();
		if (ruc.length == 11) {
			let datos = new FormData();
			datos.append('ruc', $(this).val());
			datos.append('funcion', 'buscarRuc');
			$.ajax({
				url:"ajax/inscripcion.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success:function(response){
			    	if (response.success != true) {
			    		$('#txtRuc').val('');
			    		alert('¡El número de RUC: '+ruc+' no fue econtrado! Vuelva a intentarlo.');
			    	}else{
			    		$('#txtNombreMunicipalidad').val(response.data.name);
			    		$('#txtDireccionMunicipalidad').val(response.data.address);
			    	}
			    }
		  	});
		}else{
			$('#txtNombreMunicipalidad').val('');
    		$('#txtDireccionMunicipalidad').val('');
		}
	});
	/*----------  verificar imagen  ----------*/
	$('input[name="logoMunicipalidad"]').change(function(){
		let imagen = this.files[0];
		/*----------  validamos el formato de la imagen  ----------*/
		if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
			$('input[name="logoMunicipalidad"]').val("");
	        msjModal('El tipo de imagen no es valido', 'Error al cargar la imagen');
		}else if (imagen['size'] > 2097152){
			$('input[name="logoMunicipalidad"]').val('');
			msjModal('El tipo de imagen es demasiado grande', 'Error al cargar la imagen');
		}
	});

	/*----------  Agregar inscripcion  ----------*/
	$('#inscribirMuniciaplidad').submit(event=>{
		if( $('input[name="checkCondiciones"]').prop('checked') ) {
			let errores = [
				{"elemento":"cmbDepartamentos", "mensaje":"Selecione un departamento"}, 
				{"elemento":"txtNombreMunicipalidad", "mensaje":"Nombre de municipalidad vacio"}, 
				{"elemento":"txtNombreMunicipalidad", "mensaje":"Nombre de municipalidad vacio"}, 
			 	{"elemento":"txtDireccionMunicipalidad", "mensaje":"Direccion de la municipalidad vacio"},
			 	{"elemento":"txtDniResponsable", "mensaje":"DNI vacio"},
			 	{"elemento":"txtApellidoMaterno", "mensaje":"Apellido materno vacio"},
			 	{"elemento":"txtApellidoPaterno", "mensaje":"Apellido paterno vacio"},
			 	{"elemento":"txtNombres", "mensaje":"Nombres vacios"},
			 	{"elemento":"txtCorreoResponsable", "mensaje":"Correo vacio"},
			 	{"elemento":"txtCelularResponsable", "mensaje":"Celular no rellenado"}
		 	];
			let probado = verVacio(errores)
			if(probado != 'ok'){
				$('body').append(probado);
				$('#btnClose').click(function(){
			        $('.modal_wrap').remove();
			    });
			}else{
				let formData = new FormData($('#inscribirMuniciaplidad')[0]);
				formData.append('txtApellidoPaterno', $('#txtApellidoPaterno').val());
				formData.append('txtApellidoMaterno', $('#txtApellidoMaterno').val());
				formData.append('txtNombres', $('#txtNombres').val());
				$.ajax({
					url:"ajax/inscripcion.ajax.php",
					method: "POST",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					success:function(response){
						if (response == 'error1') {
							msjModal('Número de DNI o celular no validos', 'Error al rellenar datos');
						}else if (response == 'existe') {
							msjModal('La municipalidad o la persona ya se encuetra registrada', 'Advertencia');
						}else if(response == 'error'){
							msjModal('¡Ah ocurrido un error! <br>contactese al correo: cristian0073@hotmail.com', 'Error al realizar la inscripción');
						}else if (response > 0) {
							let mensajeModal = '<div class="modal_wrap">'+
							    '<div class="mensaje_modal">'+
							        '<h3>¡Inscripción con exito!</h3>'+
							        '<p><i class="fas fa-check"></i> La municipalidad fue registrada con exito, Revise su correo dentro de las 24 horas para la generación de usuario</p>'+
							        '<span id="btnClose">Cerrar</span>'+
							    '</div>'+
							'</div>';
							$('body').append(mensajeModal);
							$('#btnClose').click(function(){
								$('.modal_wrap').remove();
								window.location = rutaDominio;
							});
						}
				    }
			  	});
			}
		}else{
			msjModal('Lea los terminos y condiciones', 'Error');
		}
		event.preventDefault();
	});
	
})



function mostrarDistritos(idProvincia){
	let id = idProvincia;
	let funcion = 'mostrarDistritos';
	let datos = new FormData();
	let template = '';
	datos.append("idProvincia", id);
	datos.append("funcion", funcion);
	$.ajax({
		url:"ajax/inscripcion.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		    success:function(response){
		    	response.forEach(valor =>{
					template +=`
						<option value="${valor.idDistrito}">${valor.nombreDistrito}</option>
					`;
		    	});
		    	$('#cmbDistritos').html(template);
		    	$('#cmbDistritos').attr('disabled', false);
		    }
  	});
}

function verVacio(arrErrores){
	let mensajes = '';
	arrErrores.forEach(errores =>{
		let vacio = $('#'+errores.elemento).val();
		if (vacio.trim() == '') {
			mensajes += '<p><i class="fas fa-times"></i> '+errores.mensaje+'</p>';
		}
	});
	if (mensajes != '') {
        let mensajeModal = '<div class="modal_wrap">'+
                            '<div class="mensaje_modal">'+
                                '<h3>Errores encontrados</h3>'+
                                mensajes+
                                '<span id="btnClose">Cerrar</span>'+
                            '</div>'+
                        '</div>';

    	return mensajeModal;

	}else{
		return 'ok';
	}
}

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