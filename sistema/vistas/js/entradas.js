$(document).ready(function(){
	$('.select2').select2();
	mostrarDataTable('tablaEntradas', 'tablaEntradas.ajax.php');
});

$(document).on("change", "#cmbEntradaProductos", function(){
	$("#cmbEntradaProductos").find("option[value='']").remove();
});

$(document).on("change", "#cmbEntradaProveedores", function(){
	$("#cmbEntradaProveedores").find("option[value='']").remove();
});

$(document).on("click", "#btnNuevaEntrada", function(){
	$("#formAgregarEntrada")[0].reset();
	borrarOptioSelect('cmbEntradaProductos', $("#cmbEntradaProductos option").length);
	borrarOptioSelect('cmbEntradaProveedores', $("#cmbEntradaProveedores option").length);
	$("#cmbEntradaProductos").prepend("<option value='' selected='selected'>Seleccione Producto</option>");
	$("#cmbEntradaProveedores").prepend("<option value='' selected='selected'>Seleccione Proveedor</option>");
});