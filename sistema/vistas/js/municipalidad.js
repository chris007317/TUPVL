$(document).ready(function (event){
	let idTipoBeneficiario = $('#cmbTipoBeneficiarios').val();
	let datos = new FormData();
	datos.append('id', idTipoBeneficiario);
	datos.append('funcion', 'mostrarRequisitos');
	let datos2 = new FormData();
	datos2.append('funcion', 'mostrarLocalidad');
	let datos3 = new FormData();
	datos3.append('funcion', 'mostrarDatosPeriodo');
	mostrarDatos(datos, "ajax/requisito-municipalidad.ajax.php", 'cuerpoTablaRequisitos');
	mostrarDatos(datos2, "ajax/localidad.ajax.php", 'cuerpoTablaLocalidad');
	mostrarDatos(datos3, "ajax/municipalidad.ajax.php", 'tablaPeriodos');

});

$(document).on('click', '#btnAgregarLocalidad', function(){
	$("#formAgregarLocalidad")[0].reset();
});

$(document).on("change", "#cmbTipoBeneficiarios", function(){
	let datos = new FormData();
	datos.append('id', $(this).val());
	datos.append('funcion', 'mostrarRequisitos');
	mostrarDatos(datos, "ajax/requisito-municipalidad.ajax.php", 'cuerpoTablaRequisitos');
});

$(document).on("change", "#cmbAgregarTipoBenef", function(){
	$("#cmbAgregarTipoBenef").find("option[value='']").remove();
});

$(document).on("change", "#cmbAgregarRequisitoBenef", function(){
	$("#cmbAgregarRequisitoBenef").find("option[value='']").remove();
});

$(document).on("change", "#cmbAgregarLocalidad", function(){
	$("#cmbAgregarLocalidad").find("option[value='']").remove();
});
/*----------  activar y desactivar requisito  ----------*/
$(document).on("click", ".btnActivarRequisito", function(){
	let idReMuni = $(this).attr('idReMuni');
	let estado = $(this).attr('estadoReMuni');
	let boton = $(this);
	let datos = new FormData();
	datos.append('idReMuni', idReMuni);
	datos.append('estadoReMuni', estado);
	datos.append('funcion', 'editarEstado');
	acivarDesactivar(datos, estado, "ajax/requisito-municipalidad.ajax.php", boton, 'estadoReMuni');
});
/*----------  activar y desactivar localidad  ----------*/
$(document).on("click", ".btnActivarLocalidad", function(){
	let idLocalidad = $(this).attr('idLocalidad');
	let estado = $(this).attr('estadoLocalidad');
	let boton = $(this);
	let datos = new FormData();
	datos.append('idLocalidad', idLocalidad);
	datos.append('estadoLocalidad', estado);
	datos.append('funcion', 'editarEstadoLocalidad');
	acivarDesactivar(datos, estado, "ajax/localidad.ajax.php", boton, 'estadoLocalidad');
});

/*----------  eliminar requisito  ----------*/
$(document).on("click", ".eliminarRequisitoMunicipalidad", function(){
	let idReMuni = $(this).attr('idReMuni');
	swal({
		title: "¿Está seguro de eliminar este requisito?",
		text: "¡Si no lo está puede cancelar la acción!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#0DAC7B',
		cancelButtonColor: "#D33",
		cancelButtonText: "¡Cancelar!",
		confirmButtonText: "Si, elimnar" 
	}).then(function(result){
		if (result.value) {
			let datos = new FormData();
			datos.append("idReMuni", idReMuni);
			datos.append("funcion", 'elimarRequisitoMuni');
			$.ajax({
				url: 'ajax/requisito-municipalidad.ajax.php',
				method: 'POST',
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function(response){
					if (response == "ok") {
						swal({
							title: "CORRECTO",
							text: "EL requisito fue eliminado correctamente",
							type: "success",
							showConfirmButton: true,
							confirmButtonText: "¡Aceptar!",
							closeOnConfirm: false
						}).then(function(result){
							if (result.value) {
								let idTipoBeneficiario = $('#cmbTipoBeneficiarios').val();		
								let datos = new FormData();
								datos.append('id', idTipoBeneficiario);
								datos.append('funcion', 'mostrarRequisitos');						
								mostrarDatos(datos, "ajax/requisito-municipalidad.ajax.php", 'cuerpoTablaRequisitos');
							}
						});
					}
				}
			});
		}
	});
});

/*----------  Editar banner  ----------*/
$(document).on("click", "#btnEditarImgMuni", function(){
	var idMunicipalidad = $(this).attr("idMunicipalidad");
	var datos = new FormData();
	datos.append('idMunicipalidad', idMunicipalidad);
	datos.append('funcion', 'mostrarDatosMuni');
	$.ajax({
		url: "ajax/municipalidad.ajax.php",
		method: "POST",
  		data: datos,
  		cache: false,
		contentType: false,
    	processData: false,
    	dataType: "json",
		success:function(response){
			$('input[name="idMunicipalidad"]').val(response['idMunicipalidad']);
			$('input[name="imgActualMuni"]').val('vistas/'+response['imagenMunicipalidad']);
			$('#previsualizarMuni').attr('src', 'vistas/'+response['imagenMunicipalidad']);
		}
	})
});

$('input[name="imgEditarMuni"]').change(function(){
	var imagen = this.files[0];
	mostrarImagen("imgEditarMuni", imagen, "previsualizarMuni")
});
/*----------  mostrar datos para editar  ----------*/
$(document).on("click", ".editarLocalidad", function(){
	let idLocalidad = $(this).attr('idLocalidad');
	let ver = '';
	let datos = new FormData();
	datos.append('idLocalidad', idLocalidad);
	datos.append('funcion', 'mostrarLocalidadMuni');
	$.ajax({
		url: 'ajax/localidad.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success:function(response){
  			$('input[name="idLocalidad"]').val(response['idLocalidad']);
  			$('#cmbEditarLocalidad').val(response['idTipoLocalidad']);
  			$('input[name="txtEditarLocalidad"]').val(response['nombreLocalidad']);
	    }
  	});	
});
/*----------  editar la localidad  ----------*/
$('#formEditarLocalidad').submit(event=>{
	let formData = new FormData($('#formEditarLocalidad')[0]);
	$.ajax({
		url:"ajax/localidad.ajax.php",
		method: "POST",
		data: $('#formEditarLocalidad').serialize(),
		cache: false,
		success:function(response){
			if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡La localidad fue editado con exito!', 'success');
				$('#formEditarLocalidad').trigger('reset');
				$("#editarLocalidad").modal('hide');
					let datos = new FormData();
					datos.append('funcion', 'mostrarLocalidad');
					mostrarDatos(datos, "ajax/localidad.ajax.php", 'cuerpoTablaLocalidad');
			}else if (response == 'existe'){
				mensaje('ADVERTENCIA!', '¡La localidad ya existe!', 'warning');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});

$(document).on('change', '#cmbPeriodo', function(){
	$(this).find("option[value='']").remove();
});