$(document).ready(function(){
	$('.select2').select2();	
	mostrarDataTable('tablePrograma', 'tablaListaPrograma.ajax.php');
});

$(document).on('change', '#cmbNombreProducto', function(){
	$("#cmbNombreProducto").find("option[value='']").remove();
});

$(document).on("click", "#btnVerProducto", function(){
	let nombreProducto = $("#cmbNombreProducto").val(); 
	let year = $("#cmbYear").val(); 
	let datos = new FormData();
	datos.append('funcion', 'mostrarProducto');
	datos.append('nombreProducto', nombreProducto);
	datos.append('year', year);
	buscarEnTabla('tablePrograma', 'tablaListaPrograma.ajax.php', datos);	
});