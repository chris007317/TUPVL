$(document).ready(function (event){
	let datos = new FormData();
	datos.append('dato', '');
	datos.append('pagina', 0);
	datos.append('funcion', 'buscarProductos');
	mostrarDatos(datos, "ajax/productos.ajax.php", 'cuerpoProductos');
	let datos2 = new FormData();
	datos2.append('dato', '');
	datos2.append('pagina', 1);
	datos2.append('funcion', 'contarProductos');
	mostrarDatos(datos2, "ajax/productos.ajax.php", 'paginador');
});
/*----------  previsualizar la imagen del producto  ----------*/
$('input[name="flImgProducto"]').change(function(){
	var imagen = this.files[0];
	mostrarImagen("flImgProducto", imagen, "imgVerProducto")
});
/*----------  mostrar modal de agregar producto  ----------*/
$(document).on("click", "#btnAgregarProducto", function(){
	$("#formAgregarProducto")[0].reset();
	$('#imgVerProducto').attr('src', '');
});
/*----------  cambiar de página  ----------*/
$(document).on("click", ".btnPagina", function(){
	let pagina = $(this).attr('pagina');
	let valor = $(this).attr('valor');
	let datos = new FormData();
	datos.append('dato', valor);
	datos.append('pagina', pagina);
	datos.append('funcion', 'buscarProductos');
	mostrarDatos(datos, "ajax/productos.ajax.php", 'cuerpoProductos');
	let datos2 = new FormData();
	datos2.append('dato', valor);
	datos2.append('pagina', pagina);
	datos2.append('funcion', 'contarProductos');
	mostrarDatos(datos2, "ajax/productos.ajax.php", 'paginador');
});
/*----------  Buscar productos  ----------*/
$(document).on('keyup', "#txtBuscarUser", function(){
	let buscar = $(this).val();
	let datos = new FormData();
	datos.append('dato', buscar);
	datos.append('pagina', 0);
	datos.append('funcion', 'buscarProductos');
	mostrarDatos(datos, "ajax/productos.ajax.php", 'cuerpoProductos');
	$('.btnPagina').attr('valor', buscar);
	let datos2 = new FormData();
	datos2.append('dato', buscar);
	datos2.append('pagina', 1);
	datos2.append('funcion', 'contarProductos');
	mostrarDatos(datos2, "ajax/productos.ajax.php", 'paginador');
});
/*----------  Editar datos  ----------*/
$(document).on("click", ".editarProducto", function(){
	var idProducto = $(this).attr("idProducto");
	var datos = new FormData();
	datos.append('idProducto', idProducto);
	datos.append('funcion', 'mostrarProduto');
	$.ajax({
		url: "ajax/productos.ajax.php",
		method: "POST",
  		data: datos,
  		cache: false,
		contentType: false,
    	processData: false,
    	dataType: "json",
		success:function(response){
			$('#txtEditarNombreProducto').val(response['nombreProducto']);
			$('input[name="txtEditarMarcaProducto"]').val(response['marcaProducto']);
			$('input[name="txtEditarCodigoProducto"]').val(response['codigoProducto']);
			$('input[name="imgActualProd"]').val(response['imgProducto']);
			$('#imgVerProd').attr('src', response['imgProducto']);
			$('textarea[name="txtEditarDescripcionProducto"]').val(response['descripcionProducto']);
			$('input[name="btxtEditarPesoProducto"]').val(response['pesoUnidad']);
			$('input[name="txtEditarPrecioProducto"]').val(response['precioUnidad']);
			$('input[name="idProducto"]').val(response['idProducto']);
		}
	})
});
/*----------  cambiar imagen  ----------*/
$('input[name="flEditarImgProducto"]').change(function(){
	var imagen = this.files[0];
	mostrarImagen("flEditarImgProducto", imagen, "imgVerProd")
});
/*----------  activar y desactivar productos  ----------*/
$(document).on("click", ".btnActivarProducto", function(){
	let idProducto = $(this).attr('idProducto');
	let estado = $(this).attr('estadoProducto');
	let boton = $(this);
	let datos = new FormData();
	datos.append('idProducto', idProducto);
	datos.append('estadoProducto', estado);
	datos.append('funcion', 'editarEstado');
	acivarDesactivar(datos, estado, "ajax/productos.ajax.php", boton, 'estadoProducto');
});