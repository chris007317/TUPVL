$(document).ready(function(){
	$('.select2').select2();	
	mostrarDataTable('tablaUsuarios', 'tablaUsuarios.ajax.php');
});

$(document).on("click", "#btnAgregarUsuario", function(){
	$("#formAgregarUsuario")[0].reset();
	$('input[name="txtApellidoPaterno"]').attr('readonly', 'readonly'); 
	$('input[name="txtApellidoMaterno"]').attr('readonly', 'readonly'); 				
	$('textarea[name="txtNombreUsuario"]').attr('readonly', 'readonly'); 
	$('#imgVerProducto').attr('src', '');
});

/*----------  mostrar datos con ruc  ----------*/
$(document).on("click", "#btnBuscarUsurio", function(){
	let dni = $('input[name="txtDniUsuario"]').val(); 
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
					alertas('alertaDniUsuario', '<i class="far fa-window-close"></i> No se encontró resultados');
					$('input[name="idPersona"]').val('');	
					$('input[name="txtApellidoPaterno"]').removeAttr('readonly'); 
					$('input[name="txtApellidoMaterno"]').removeAttr('readonly'); 				
					$('input[name="txtNombreUsuario"]').removeAttr('readonly');
				}else{
					if (typeof response['idPersona'] == "undefined" || response['idPersona'] == null){
						let respuesta = JSON.parse(response);
						if (respuesta.valor == 'vacio' || respuesta.name == '') {		
							$('input[name="txtApellidoPaterno"]').removeAttr('readonly'); 
							$('input[name="txtApellidoMaterno"]').removeAttr('readonly'); 				
							$('input[name="txtNombreUsuario"]').removeAttr('readonly'); 	
							$('input[name="txtApellidoPaterno"]').val(''); 
							$('input[name="txtApellidoMaterno"]').val(''); 				
							$('input[name="txtNombreUsuario"]').val(''); 	
							$('input[name="idPersona"]').val('');				
							alertas('alertaDniUsuario1', '<i class="fas fa-info-circle"></i> No se ha encontrado ningun resultado');
						}else{
							$('input[name="txtApellidoPaterno"]').val(respuesta.first_name); 
							$('input[name="txtApellidoMaterno"]').val(respuesta.last_name); 				
							$('input[name="txtNombreUsuario"]').val(respuesta.name); 		
				 			$('input[name="txtApellidoPaterno"]').attr('readonly', 'readonly'); 
							$('input[name="txtApellidoMaterno"]').attr('readonly', 'readonly'); 				
							$('input[name="txtNombreUsuario"]').attr('readonly', 'readonly'); 		
							$('input[name="idPersona"]').val('');	
						}
					}else{
						$('input[name="txtApellidoPaterno"]').val(response['apellidoPaternoPersona']); 
						$('input[name="txtApellidoMaterno"]').val(response['apellidoMaternoPersona']); 				
						$('input[name="txtNombreUsuario"]').val(response['nombrePersona']); 		
			 			$('input[name="txtApellidoPaterno"]').attr('readonly', 'readonly'); 
						$('input[name="txtApellidoMaterno"]').attr('readonly', 'readonly'); 				
						$('input[name="txtNombreUsuario"]').attr('readonly', 'readonly'); 
						$('input[name="idPersona"]').val(response['idPersona']);	
					}
				}
		    }
	  	});
	}else{
		alertas('alertaDniUsuario', '<i class="far fa-window-close"></i> La busqueda no se ah realizado');
	}
}); 

/*----------  previsualizar la imagen del producto  ----------*/
$('input[name="flImgUsuario"]').change(function(){
	var imagen = this.files[0];
	mostrarImagen("flImgProducto", imagen, "imgVerUsuario")
});

$(document).on('change', '#cmbPerfil', function(){
	$(this).find("option[value='']").remove();
});

$(document).on('click', '.editarUsuario', function(){
	$("#formEditarUsuario")[0].reset();
	let idUsuario = $(this).attr('idUsuario');
	let datos = new FormData();
	datos.append('idUsuario', idUsuario);
	datos.append('funcion', 'mostrarUsuario');
	$.ajax({
		url:"ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
	    success:function(response){
	    	$('#titulo').html(response['nombrePersona']+' '+response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']);
	    	$('input[name="txtEditarCorreo"]').val(response['correoUsuario']); 
	    	$('input[name="txtEditarCeluar"]').val(response['celularUsuario']); 
	    	$('input[name="txtEditarUsuario"]').val(response['nombreUsuario']); 
	    	$('input[name="idUsuario"]').val(response['idUsuario']); 
	    	$('#cmbEditarPerfil').val(response['idTipoUsuario']);
	    }
  	});
});

$('#formEditarUsuario').submit(event=>{
	$.ajax({
		url:"ajax/usuarios.ajax.php",
		method: "POST",
		data: $('#formEditarUsuario').serialize(),
		cache: false,
		success:function(response){
			if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡El usuario fue editado con exito!', 'success');
				$('#formEditarUsuario').trigger('reset');
				$("#editarUsuario").modal('hide');
					buscarEnTabla('tablaUsuarios', 'tablaUsuarios.ajax.php', '');
			}else if (response == 'existe'){
				mensaje('ADVERTENCIA!', '¡El nombre de usuario ya existe!', 'warning');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});

$(document).on('click', '.editarImg', function(){
	$("#formEditarImg")[0].reset();
	let idUsuario = $(this).attr('idUsuario');
	let datos = new FormData();
	datos.append('idUsuario', idUsuario);
	datos.append('funcion', 'mostrarUsuario');
	$.ajax({
		url:"ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
	    success:function(response){
	    	$('#tituloImg').html(response['nombrePersona']+' '+response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']);
	    	$('#imgEditar').attr('src', response['fotoUsuario']);
	    	$('input[name="idPersonaImg"]').val(response['idUsuario']);
	    	$('input[name="imgActual"]').val(response['fotoUsuario']); 
	    }
  	});
});

/*----------  cambiar imagen  ----------*/
$('input[name="flEditarImg"]').change(function(){
	var imagen = this.files[0];
	mostrarImagen("flEditarImg", imagen, "imgEditar");
	$('#btnEditar').attr("disabled", false);
});

$('#formEditarImg').submit(event=>{
	event.preventDefault();
	var formData = new FormData(document.getElementById("formEditarImg"));
	$.ajax({
		url:"ajax/usuarios.ajax.php",
		method: "POST",
		contentType: false,
		data: formData,
		processData: false,
		cache: false,
		success:function(response){
			if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡El usuario fue editado con exito!', 'success');
				$('#formEditarImg').trigger('reset');
				$("#editarImg").modal('hide');
				buscarEnTabla('tablaUsuarios', 'tablaUsuarios.ajax.php', '');
			}else if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡No se permiten formatos que no sean JPG o PNG!', 'warning');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
});

$(document).on('click', '.cambiarContra', function(){
	$("#formContra")[0].reset();
	let idUsuario = $(this).attr('idusuario');
	$('input[name="idUsuarioContra"]').val(idUsuario);
});

$('#formContra').submit(event=>{
	$.ajax({
		url:"ajax/usuarios.ajax.php",
		method: "POST",
		data: $('#formContra').serialize(),
		cache: false,
		success:function(response){
			if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡El usuario fue editado con exito!', 'success');
				$('#formContra').trigger('reset');
				$("#cambiarContra").modal('hide');
			}else if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡Las contraseñas no coinsiden', 'warning');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});

$(document).on("click", ".btnActivarUsuario", function(){
	let idusuario = $(this).attr('idusuario');
	let estado = $(this).attr('estadousuario');
	let boton = $(this);
	let datos = new FormData();
	datos.append('idusuario', idusuario);
	datos.append('estadousuario', estado);
	datos.append('funcion', 'editarEstado');
	acivarDesactivar(datos, estado, "ajax/usuarios.ajax.php", boton, 'estadousuario');
});