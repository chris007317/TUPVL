$(document).ready(function(){
	mostrarDataTable('tablaSocios', 'listaSocios.ajax.php');
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

$(document).on("click", ".editarSocio", function(){
	$("#formSocio")[0].reset();
	let idSocio = $(this).attr('idSocio');
	let datos = new FormData();
	datos.append('idSocio', idSocio);
	datos.append('funcion', 'mostrarSocio');
	$.ajax({
		url: "ajax/socio.ajax.php",
		method: "POST",
  		data: datos,
  		cache: false,
		contentType: false,
    	processData: false,
    	dataType: "json",
		success:function(response){
			$('input[name="txtDniSocio"]').val(response['dniPersona']);
			$('input[name="txtApellidoPaterno"]').val(response['apellidoPaternoPersona']);
			$('input[name="txtApellidoMaterno"]').val(response['apellidoMaternoPersona']);
			$('input[name="txtNombreSocio"]').val(response['nombrePersona']);
			$('input[name="txtCorreoSocio"]').val(response['correoSocio']);
			$('input[name="txtCelularSocio"]').val(response['celular']);
			$('#formSocio input[name="idSocio"]').val(response['idSocio']);
			$('#formSocio input[name="funcion"]').val('editarSocio');
		}
	});
});

$(document).on("click", ".verBeneficiarios", function(){
	let idSocio = $(this).attr('idSocio');
	let datos = new FormData();
	let template = '';
	$('#verBeneficiarios').html('');
	datos.append('item', 'idSocioBenef');
	datos.append('valor', idSocio);
	datos.append('estado', 1);
	datos.append('funcion', 'buscarBenef');
	$.ajax({
		url: "ajax/beneficiario.ajax.php",
		method: "POST",
  		data: datos,
  		cache: false,
		contentType: false,
    	processData: false,
    	dataType: "json",
		success:function(response){
			let fechaVen = '';
	    	response.forEach(valor =>{
	    		if (valor.fechaVencimiento == null) {
	    			fechaVen = 'Indefinido';
	    		}else{
	    			fechaVen = valor.fechaVencimiento;
	    		}
				template +=`
					<li class="list-group-item ">
		                <div class="d-sm-flex">                  
		                  <div class="w-40"><strong>Apellidos y nombres:</strong></div>
		                  <div class="w-60"><span>${valor.apellidoPaternoPersona} ${valor.apellidoMaternoPersona}, ${valor.nombrePersona}</span></div>
		                </div>                  
		                <div class="d-sm-flex">
		                  <div class="w-40"><strong>DNI:</strong></div>
		                  <div class="w-60"><span>${valor.dniPersona}</span></div>
		                </div>
		                <div class="d-sm-flex">                  
		                  <div class="w-40"><strong>Fecha de ven:</strong></div>
		                  <div class="w-60"><span class="badge badge-info">${fechaVen}</span></div>
		                </div>
		                <div class="d-sm-flex">                  
		                  <div class="w-40"><strong>Parentesco:</strong></div>
		                  <div class="w-60"><span>${valor.nombreTipoSocio}</span></div>
		                </div>                  
		                <div class="d-sm-flex">                  
		                  <div class="w-40"><strong>Tipo benef:</strong></div>
		                  <div class="w-60"><span>${valor.nombreTipoBeneficiario}</span></div>
		                </div>                  
		            </li>
				`;
	    	});
			if (template == '') {
				template = 'No tiene beneficiarios registrados';
			}
	    	$('#verBeneficiarios').html(template);
		}
	});
});

var estadoSocios = 1;
var btnClick = false;
$(document).on("click", "#btnActivos", function(){
	btnClick = true;
	estadoSocios = $(this).attr('estado');
	let datos = new FormData();
	datos.append('funcion', 'mostrarActivos');
	datos.append('estado', estadoSocios);
	buscarEnTabla('tablaSocios', 'listaSocios.ajax.php', datos);	
	if (estadoSocios == 1) {
		$(this).removeClass('btn-warning');
		$(this).addClass('btn-secondary');
		$(this).html('Ver socios inactivos'); 
		$(this).attr('estado', 0);
	}else{
		$(this).removeClass('btn-secondary');
		$(this).addClass('btn-warning');
		$(this).html('Ver socios activos'); 
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
				if (btnClick == true) {
					let datos = new FormData();
					datos.append('funcion', 'mostrarActivos');
					datos.append('estado', estadoSocios);
					buscarEnTabla('tablaSocios', 'listaSocios.ajax.php', datos);	
				}else{
					buscarEnTabla('tablaSocios', 'listaSocios.ajax.php', null);	
				}
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});

$(document).on("submit", "#formSocio", function(event){
	$.ajax({
		url:"ajax/socio.ajax.php",
		method: "POST",
		data: $('#formSocio').serialize(),
		cache: false,
		success:function(response){
			if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡La accion se ejecuto con exito con exito!', 'success');
				$("#formSocio")[0].reset();
				$("#modalSocio").modal('hide');
				if (btnClick == true) {
					let datos = new FormData();
					datos.append('funcion', 'mostrarActivos');
					datos.append('estado', estadoSocios);
					buscarEnTabla('tablaSocios', 'listaSocios.ajax.php', datos);	
				}else{
					buscarEnTabla('tablaSocios', 'listaSocios.ajax.php', null);	
				}
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});

$(document).on("click", ".btnActivarSocio", function(){
	let idSocio = $(this).attr('idSocio');
	let estado = $(this).attr('estadoSocio');
	let boton = $(this);
	let datos = new FormData();
	datos.append('idSocio', idSocio);
	datos.append('estadoSocio', estado);
	datos.append('funcion', 'editarEstado');
	acivarDesactivar(datos, estado, "ajax/socio.ajax.php", boton, 'estadoSocio');
	
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