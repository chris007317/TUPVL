$(document).ready(function(){
	$('.select2').select2();
	mostrarDataTable('tablaComites', 'tablaComites.ajax.php');
	let datos = new FormData();
	datos.append('funcion', 'contarComiteActivos');
	barraProgreso('comite.ajax.php', datos, 'comitesActivos', 'porcentajeComites');
}); 

$(document).on('change', '#cmbLocalidadComite', function(){
	$("#cmbLocalidadComite").find("option[value='']").remove();
});

$(document).on('change', '#cmbComiteLocalidad', function(){
	$("#cmbComiteLocalidad").find("option[value='']").remove();
	let idLocalidad = $(this).val();
	if (idLocalidad == 0) {
		buscarEnTabla('tablaComites', 'tablaComites.ajax.php', null);
	}else if(idLocalidad > 0){
		let datos = new FormData();
		datos.append('funcion', 'mostrarComiteLocalidad');
		datos.append('idLocalidad', idLocalidad);
		buscarEnTabla('tablaComites', 'comite.ajax.php', datos);
	}
});

$(document).on("click", "#btnAgregarComite", function(){
	$("#formAgregarComite")[0].reset();
	let elementos = $("#cmbLocalidadComite option").length;
	borrarOptioSelect('cmbLocalidadComite', elementos);
	$("#cmbLocalidadComite").prepend("<option value='' selected='selected'>Seleccione Localidad</option>");	
	$('#agregarComite h4').html('Agregar nuevo comité');
	$('input[name="funcion"]').val('agregar'); 
	$('input[name="idComite"]').val('');
	$('#formAgregarComite button[type="submit"]').html('Agregar'); 
});

$(document).on("click", ".btnAgregarPresidente", function(){
	$("#formAgregarPresidente")[0].reset();
	$('#agregarPresidente h4').html('Agregar nueva presidenta');
	$('#formAgregarPresidente input[name="funcionPresidente"]').val('agregar');
	$('#formAgregarPresidente input[name="idPresidente"]').val('');
	$('#formAgregarPresidente input[name="idComite"]').val($(this).attr('idComite'));
	$('#formAgregarPresidente button[type="submit"]').html('Agregar'); 
	$('#btnBuscarPresidente').css('display', 'block');
	$('input[name="txtDniPresidente"]').removeAttr('readonly');
});

/*----------  mostrar datos con ruc  ----------*/
$(document).on("click", "#btnBuscarPresidente", function(){
	let dni = $('input[name="txtDniPresidente"]').val(); 
	if (dni.length == 8 && (/^\d{8}$/.test(dni))) { 
		let datos = new FormData();
		datos.append('dni', dni);
		datos.append('funcion', 'buscarDni');
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
					alertas('alertaDniPresi', '<i class="far fa-window-close"></i> No se encontró resultados');
					$('input[name="txtApellidoPaterno"]').removeAttr('readonly'); 
					$('input[name="txtApellidoMaterno"]').removeAttr('readonly'); 				
					$('input[name="txtNombrePresidente"]').removeAttr('readonly'); 	
					$('input[name="txtApellidoPaterno"]').val(''); 
					$('input[name="txtApellidoMaterno"]').val(''); 				
					$('input[name="txtNombrePresidente"]').val(''); 			
				}else{
					if (typeof response['idPersona'] == "undefined" || response['idPersona'] == null){
						let respuesta = JSON.parse(response);
						if (respuesta.valor == 'vacio' || respuesta.name == '') {		
							$('input[name="txtApellidoPaterno"]').removeAttr('readonly'); 
							$('input[name="txtApellidoMaterno"]').removeAttr('readonly'); 				
							$('input[name="txtNombrePresidente"]').removeAttr('readonly'); 	
							$('input[name="txtApellidoPaterno"]').val(''); 
							$('input[name="txtApellidoMaterno"]').val(''); 				
							$('input[name="txtNombrePresidente"]').val(''); 				
							alertas('alertaDniPresi1', '<i class="fas fa-info-circle"></i> No se ha encontrado ningun resultado');
						}else{
							$('input[name="txtApellidoPaterno"]').val(respuesta.first_name); 
							$('input[name="txtApellidoMaterno"]').val(respuesta.last_name); 				
							$('input[name="txtNombrePresidente"]').val(respuesta.name); 		
				 			$('input[name="txtApellidoPaterno"]').attr('readonly', 'readonly'); 
							$('input[name="txtApellidoMaterno"]').attr('readonly', 'readonly'); 				
							$('input[name="txtNombrePresidente"]').attr('readonly', 'readonly'); 		
						}
					}else{
							$('input[name="txtApellidoPaterno"]').val(response['apellidoPaternoPersona']); 
							$('input[name="txtApellidoMaterno"]').val(response['apellidoMaternoPersona']); 				
							$('input[name="txtNombrePresidente"]').val(response['nombrePersona']); 		
				 			$('input[name="txtApellidoPaterno"]').attr('readonly', 'readonly'); 
							$('input[name="txtApellidoMaterno"]').attr('readonly', 'readonly'); 				
							$('input[name="txtNombrePresidente"]').attr('readonly', 'readonly'); 
					}
				}
		    }
	  	});
	}else{
		alertas('alertaDniPresi', '<i class="far fa-window-close"></i> La busqueda no se ah realizado');
	}
}); 
/*----------  activar y desactivar comites  ----------*/
$(document).on("click", ".btnActivarComite", function(){
	let idComite = $(this).attr('idComite');
	let estado = $(this).attr('estadoComite');
	let boton = $(this);
	let datos = new FormData();
	datos.append('idComite', idComite);
	datos.append('estadoComite', estado);
	datos.append('funcion', 'editarEstado');
	acivarDesactivar(datos, estado, "ajax/comite.ajax.php", boton, 'estadoComite');
	let contar = new FormData();
	contar.append('funcion', 'contarComiteActivos');
	barraProgreso('comite.ajax.php', contar, 'comitesActivos', 'porcentajeComites');
});

$(document).on("click", ".editarComite", function(){
	$("#formAgregarComite")[0].reset();
	let elementos = $("#cmbLocalidadComite option").length;
	borrarOptioSelect('cmbLocalidadComite', elementos);
	$('#agregarComite h4').html('Editar comité');
	let idComite = $(this).attr('idComite'); 
	var datos = new FormData();
	datos.append('idComite', idComite);
	datos.append('funcion', 'mostrarComite');
	$.ajax({
		url: "ajax/comite.ajax.php",
		method: "POST",
  		data: datos,
  		cache: false,
		contentType: false,
    	processData: false,
    	dataType: "json",
		success:function(response){
			$('#cmbLocalidadComite').val(response['idLocalidadComite']).trigger("change");
			$('input[name="txtNombreComite"]').val(response['nombreComite']);
			$('input[name="txtDireccionComite"]').val(response['direccionComite']);
			$('input[name="txtNumeroComite"]').val(response['numeroCalle']);
			$('textarea[name="txtDescripcionComite"]').val(response['descripcionComite']);
			$('#formAgregarComite input[name="idComite"]').val(response['idComite']); 
			$('#formAgregarComite input[name="funcion"]').val('editar'); 
			$('#formAgregarComite button[type="submit"]').html('Guardar'); 
		}
	});
});

$(document).on("click", ".editarPresidente", function(){
	$("#formAgregarPresidente")[0].reset();
	$('#agregarPresidente h4').html('Editar presidente');
	$('#formAgregarPresidente button[type="submit"]').html('Guardar'); 
	$('#formAgregarPresidente input[name="idComite"]').val('');
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
			$('#formAgregarPresidente input[name="idPresidente"]').val(response['idPresidente']);
			$('#btnBuscarPresidente').css('display', 'none');
			$('input[name="txtDniPresidente"]').attr('readonly', 'readonly'); 
			$('#formAgregarPresidente input[name="funcionPresidente"]').val('editar');
		}
	});
});

$(document).on("click", ".cambiarPresidente", function(){
	$("#formAgregarPresidente")[0].reset();
	$('#agregarPresidente h4').html('Cambiar presidente');
	$('#formAgregarPresidente input[name="funcionPresidente"]').val('cambiar');
	$('#formAgregarPresidente input[name="idPresidente"]').val($(this).attr('idPresidente'));
	$('#formAgregarPresidente input[name="idComite"]').val($(this).attr('idComite'));
	$('#formAgregarPresidente button[type="submit"]').html('Nuevo'); 
	$('#btnBuscarPresidente').css('display', 'block');
	$('input[name="txtDniPresidente"]').removeAttr('readonly');
});

