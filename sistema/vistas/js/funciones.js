/*----------  mostrar datos   ----------*/
function mostrarDatos(datos, link, tabla){
	$.ajax({
		url:link,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success:function(response){
			$('#'+tabla).html('');
			$('#'+tabla).html(response);
	    }
  	});
}
/*----------  activar y desactivar   ----------*/
function acivarDesactivar(datos, estado, link, boton, atributo){
	$.ajax({
		url: link,
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(response){
			if (response == 'no') {
				alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', 'No es posible cambiar el estado, por que hay entrega de alimentos pendiente');
			}else if (response.trim() == 'ok') {
				if (estado == 0) {
					$(boton).removeClass('btn-warning');
					$(boton).addClass('btn-secondary');
					$(boton).html('Inactivo'); 
					$(boton).attr(atributo, 1);
				}else{
					$(boton).removeClass('btn-secondary');
					$(boton).addClass('btn-warning');
					$(boton).html('Activo'); 
					$(boton).attr(atributo, 0);
				}
			}else{
				alertaMensaje('top-right', '<i class="far fa-question-circle"></i>', 'No es posible cambiar el estado');	
			}
		}
	});
}

function mensaje(titulo, mensaje, tipo){
	swal({
		title: titulo,
		text: mensaje,
		type: tipo,
		showConfirmButton: true,
		confirmButtonText: "¡Aceptar!",
	});
}
/*----------  mensaje de alerta flotante  ----------*/
function alertaMensaje(posicion, icono, mensaje){
	swal({
		position: posicion,
		width: '400px',
		showConfirmButton: false,
		timer: 1500,
		html:'<p class="text-secondary">'+icono+'<span style="font-size: 14px"> '+mensaje+'</span></p>'
	});
}

/*----------  Mostrar imagen previa  ----------*/
function mostrarImagen(nombreFile, imagen, imgMostrar){
	/*----------  validamos el formato de la imagen  ----------*/
	if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
		$('input[name="'+nombreFile+'"]').val("");
		swal({
			title: "¡Error al subir imagen!",
			text: "La imagen debe estar en formato JPG o PNG",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		});
	}else if (imagen['size'] > 2097152){
		$('input[name="'+nombreFile+'"]').val('');
		swal({
			title: "¡Error al subir imagen!",
			text: "La imagen es demasiado grande",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		});
	}else{
		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);
		$(datosImagen).on("load", function(event){
			var rutaImagen = event.target.result;
			$("#"+imgMostrar).attr("src", rutaImagen);
		});

	}
}
/*----------  mostrar alertas  ----------*/
function alertas(nombre, mensaje){
	$('#'+nombre+' span').html(mensaje);
	$('#'+nombre).hide('slow');
	$('#'+nombre).show(1500);
	$('#'+nombre).hide(2000);
}
/*----------  mostrar tablas en data Table  ----------*/
function mostrarDataTable(tabla, link){
	$('#'+tabla).DataTable({
		"ajax":"ajax/"+link,
		"pageLength": 25,
		"deferRender":true,
		"retrieve":true,
		"processing":true,
		"language": {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "Último",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		}
	});
}
/*----------  borrar el primer option de un select  ----------*/
function borrarOptioSelect(cmb, elementos){
	for (var i = 0; i <= elementos; i++) {
		$("#"+cmb).find("option[value='']").remove();
	}
}

function buscarEnTabla(tabla, link, datos){
		$.ajax({
		url: "ajax/"+link,
		type: "POST",
  		data: datos,
  		cache: false,
		contentType: false,
    	processData: false,
    	dataType: "json",
		success:function(response){
			let datatable = $('#'+tabla).DataTable({
				"pageLength": 25,
				"deferRender":true,
				"retrieve":true,
				"processing":true,
				"language": {
					"sProcessing":     "Procesando...",
					"sLengthMenu":     "Mostrar _MENU_ registros",
					"sZeroRecords":    "No se encontraron resultados",
					"sEmptyTable":     "Ningún dato disponible en esta tabla",
					"sInfo":           "Mostrando registros del _START_ al _END_",
					"sInfoEmpty":      "Mostrando registros del 0 al 0",
					"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
					"sInfoPostFix":    "",
					"sSearch":         "Buscar:",
					"sUrl":            "",
					"sInfoThousands":  ",",
					"sLoadingRecords": "Cargando...",
					"oPaginate": {
						"sFirst":    "Primero",
						"sLast":     "Último",
						"sNext":     "Siguiente",
						"sPrevious": "Anterior"
					},
					"oAria": {
						"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
						"sSortDescending": ": Activar para ordenar la columna de manera descendente"
					}
				}
			});			 
		    datatable.clear(); 
		    datatable.rows.add(response.data); 
		    datatable.draw(); 
		}
	});
}

function mostrarDatosCmb(datos, link, cmb, idSelect){
	let template = '';
	$.ajax({
		url:"ajax/"+link,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
	    success:function(response){
	    	response.forEach(valor =>{
	    		if (idSelect != valor.valor) {
					template +=`
						<option value="${valor.valor}">${valor.nombre}</option>
					`;
	    		}else{
					template +=`
						<option value="${valor.valor}" selected>${valor.nombre}</option>
					`;
	    		}
	    	});
	    	$('#'+cmb).html(template);
	    	$('#'+cmb).attr('disabled', false);
	    }
  	});
}

function barraProgreso(link, datos, idCant, idbar){
	$.ajax({
		url:'ajax/'+link,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success:function(response){
			let porcentaje = (response['cantidad'] * 100) / response['total'];
			$('#'+idCant).html(response['cantidad'] +' de '+ response['total'] + ', igual al ' + porcentaje.toFixed(2) + '%');
			$('#'+idbar).css('width', porcentaje.toFixed(2)+'%');
    	}
  	});
}

function verCero(val) {
	let nuevo 
    if (val >= 10){
    	nuevo = val; 
    } 
    else{
    	nuevo = '0' + val; 
    } 
    return nuevo;
} 

function generarPDF(idPostulante, idInscipcion){
    var ancho = 1800;
    var alto = 1200;
    //Calcular la posicion x, y para calcular la venta
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));
	$url = 'generarficha/'+idPostulante+'/'+idInscipcion;
	window.open($url,"Inscripción", "left="+x+",top="+y+",height="+alto+",width"+ancho+",scrollbar=si,location=no, resizable=si,menubar=no");
}

function compararFechas(fecha1, fecha2){
	let valor = 0;

	if( new Date(fecha1).getTime() > new Date(fecha2).getTime()){
      	valor = 1;
    }else if( new Date(fecha1).getTime() < new Date(fecha2).getTime()){
		valor = 2;
	}else if( new Date(fecha1).getTime() === new Date(fecha2).getTime()){
		valor = 3;
	}
	return valor;
}

/*----------  activar y desactivar   ----------*/
function nuevosPostulantes(datos, link, elemento){
	$.ajax({
		url: link,
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(response){
			$('#'+elemento).html(response); 
		}
	});
}

function mensajeReload(titulo, mensaje, tipo){
	swal({
		title: titulo,
		text: mensaje,
		type: tipo,
		showConfirmButton: true,
		confirmButtonText: "¡Aceptar!",
	}).then(function(result){
		if(result.value){
			location.reload();
		}
	});
}
/*----------  ver registro beneficiarios   ----------*/
function verBeneficiarios(datos, btn, link){
	$.ajax({
		url: link,
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success:function(response){
			 if (response=='no') {
			 	validarBen = 0;
				$(btn).hide();
				mensaje('¡Advertencia!', '¡No puede registrar nuevo beneficiario por que hay entrega de alimentos pendientes!', 'warning');
			}
	    }
  	});
}