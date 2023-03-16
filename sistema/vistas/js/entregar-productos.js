
$(document).ready(function(){
	$('.select2').select2();	
	//mostrarDataTable('tablaEntregarProductos', 'tablaEntregarProductos.ajax.php');
});

$(document).on('change', '#cmNombreMes', function(){
	$("#cmNombreMes").find("option[value='']").remove();
});

$(document).on('click', '#btnVerEntrega', function(){
	let idMes = $("#cmNombreMes").val(); 
	let year = $("#cmbYear").val(); 
	let datos = new FormData();
	datos.append('idMes', idMes);
	datos.append('year', year);
	buscarEnTabla('tablaEntregarProductos', 'tablaEntregarProductos.ajax.php', datos);	
});

$(document).on('click', '.avena', function(){
	$('#formEntregarALimento input[name="dateFechaAlimento"]').val('');
	let cantAvena = $(this).attr('avena');
	let idMes = $(this).attr('idMes');
	let idComite = $(this).attr('idComite');
	let year = $(this).attr('year');
	$('#nombreComite').html($(this).attr('comite'));
	$('#cantBenef').html($(this).attr('beneficiarios'));
	$('#cantAlimento').html(cantAvena);
	$('#nombreAlimento').html('Avena');
	/*----------  rellenar los imputs del form  ----------*/
	$('#formEntregarALimento input[name="idComite"]').val(idComite);
	$('#formEntregarALimento input[name="idMes"]').val(idMes);
	$('#formEntregarALimento input[name="yearEntrega"]').val(year);
	$('#formEntregarALimento input[name="cantidadEntrega"]').val(cantAvena);

	let datos = new FormData();
	datos.append("yearPerido", year);
	datos.append("mes", idMes);
	datos.append("nombreProducto", 'avena');
	datos.append("funcion", 'verProductos');
	datos.append("cantidad", cantAvena);
	verProductos(datos);
	$('.content-wrapper').css('margin-right', '0px');
});

$(document).on('click', '.leche', function(){
	$('#formEntregarALimento input[name="dateFechaAlimento"]').val('');
	let idMes = $(this).attr('idMes');
	let cantLeche = $(this).attr('leche');
	console.log("cantLeche", cantLeche);
	let idComite = $(this).attr('idComite');
	let year = $(this).attr('year');

	$('#nombreComite').html($(this).attr('comite'));
	$('#cantBenef').html($(this).attr('beneficiarios'));
	$('#cantAlimento').html(cantLeche);
	$('#nombreAlimento').html('Leche');
	/*----------  rellenar los imputs del form  ----------*/
	$('#formEntregarALimento input[name="idComite"]').val(idComite);
	$('#formEntregarALimento input[name="idMes"]').val(idMes);
	$('#formEntregarALimento input[name="yearEntrega"]').val(year);
	$('#formEntregarALimento input[name="cantidadEntrega"]').val(cantLeche);

	let datos = new FormData();
	datos.append("yearPerido", year);
	datos.append("mes", idMes);
	datos.append("nombreProducto", 'leche');
	datos.append("funcion", 'verProductos');
	datos.append("cantidad", cantLeche);
	verProductos(datos); 
	$('.content-wrapper').css('margin-right', '0px');
});

function verProductos(datos){
	$.ajax({
		url: 'ajax/almacen.ajax.php',
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(response){
			$('#listaAlimento').html(response);
			
		}
	});	
}

$(document).on("submit", "#formEntregarALimento", function(event){
	$.ajax({
		url:"ajax/almacen.ajax.php",
		method: "POST",
		data: $('#formEntregarALimento').serialize(),
		cache: false,
		success:function(response){
			if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡Ocurrio un error! comuniquese con el administrador', 'warning');
			}else if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡La accion se ejecuto con exito con exito!', 'success');
				$("#entregarAlimento").modal('hide');
				let idMes = $("#cmNombreMes").val(); 
				let year = $("#cmbYear").val(); 
				let datos = new FormData();
				datos.append('idMes', idMes);
				datos.append('year', year);
				buscarEnTabla('tablaEntregarProductos', 'tablaEntregarProductos.ajax.php', datos);	
				$('body').css('margin-right', '0px');
				$('body').css('padding-right', '0px');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador de inmediato.' , 'error');
			}
	    }
  	});
	$('body').css('padding-right', '0px');
	event.preventDefault();
});