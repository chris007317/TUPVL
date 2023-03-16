$(document).ready(function(){
	$('.select2').select2();
	mostrarDataTable('tablaProveedores', 'tablaProveedores.ajax.php');
});
/*----------  mostrar datos con ruc  ----------*/
$(document).on("click", "#btnBuscarProveedor", function(){
	let ruc = $('input[name="txtRucProveedor"]').val(); 
	if (ruc.length == 11) {
		let datos = new FormData();
		datos.append('ruc', ruc);
		datos.append('funcion', 'buscarRuc');
		$.ajax({
			url:"ajax/proveedor.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'json',
			success:function(response){
			 	if (response == 'error') {
					$('input[name="txtNombreProveedor"]').attr('disabled', false); 
					$('input[name="txtDireccionProveedor"]').attr('disabled', false); 	
					alertas('alertaRuc', '<i class="far fa-window-close"></i> No se encontró resultados');
				}else{
					let respuesta = JSON.parse(response);
					if (respuesta.valor == 'vacio') {
						$('input[name="txtNombreProveedor"]').attr('disabled', false); 
					$('input[name="txtDireccionProveedor"]').attr('disabled', false); 						
						alertas('alertaRuc1', '<i class="fas fa-info-circle"></i> No se ha encontrado ningun resultado');
					}else{
						$('input[name="txtNombreProveedor"]').val(respuesta.razon_social); 
						$('input[name="txtDireccionProveedor"]').val(respuesta.domicilio_fiscal);
						$('input[name="txtNombreProveedor"]').attr('disabled', true); 
						$('input[name="txtDireccionProveedor"]').attr('disabled', true);
					}
				}
		    }
	  	});
	}else{
		alertas('alertaRuc', '<i class="far fa-window-close"></i> La busqueda no se ah realizado');
	}
});

$(document).on("click", "#btnAgregarProveedor", function(){
	$("#formAgregarProveedor")[0].reset();
});

/*----------  activar y desactivar proveedores  ----------*/
$(document).on("click", ".btnActivarProveedores", function(){
	let idProveedor = $(this).attr('idProveedor');
	let estado = $(this).attr('estadoProveedor');
	let boton = $(this);
	let datos = new FormData();
	datos.append('idProveedor', idProveedor);
	datos.append('estadoProveedor', estado);
	datos.append('funcion', 'editarEstado');
	acivarDesactivar(datos, estado, "ajax/proveedor.ajax.php", boton, 'estadoProveedor');
});
/*----------  Editar datos  ----------*/
$(document).on("click", ".editarProveedor", function(){
	var idProveedor = $(this).attr("idProveedor");
	var datos = new FormData();
	datos.append('idProveedor', idProveedor);
	datos.append('funcion', 'mostrarProveedor');
	$.ajax({
		url: "ajax/proveedor.ajax.php",
		method: "POST",
  		data: datos,
  		cache: false,
		contentType: false,
    	processData: false,
    	dataType: "json",
		success:function(response){
			$('input[name="txtEditarRucProveedor"]').val(response['rucProveedor']);
			$('input[name="txtEditarNombreProveedor"]').val(response['nombreProveedor']);
			$('input[name="txtEditarDireccionProveedor"]').val(response['direccionProveedor']);
			$('input[name="txtEditarRepresentanteProveedor"]').val(response['representanteProveedor']);
			$('input[name="txtEditarCelularProveedor"]').val(response['telefonoProveedor']);
			$('input[name="txtEditarCorreoProveedor"]').val(response['correoProveedor']);
			$('input[name="idProveedor"]').val(response['idProveedor']);
		}
	})
});