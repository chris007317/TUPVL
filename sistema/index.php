<?php 
	require_once "controlador/plantilla.controlador.php";
	require_once "controlador/ruta.controlador.php";

	require_once "controlador/usuario.controlador.php";
	require_once "modelo/usuario.modelo.php";

	require_once "controlador/municipalidad.controlador.php";
	require_once "modelo/municipalidad.modelo.php";

	require_once "controlador/requisito.controlador.php";
	require_once "modelo/requisitos.modelo.php";

	require_once "controlador/tipo-beneficiario.controlador.php";
	require_once "modelo/tipo-beneficiario.modelo.php";

	require_once "controlador/requisito-municipalidad.controlador.php";
	require_once "modelo/requisito-municipalidad.modelo.php";

	require_once "controlador/localidadad.controlador.php";
	require_once "modelo/localidad.modelo.php";

	require_once "controlador/producto.controlador.php";
	require_once "modelo/producto.modelo.php";

	require_once "controlador/proveedor.controlador.php";
	require_once "modelo/proveedor.modelo.php";

	require_once "controlador/entrada.controlador.php";
	require_once "modelo/entrada.modelo.php";

	require_once "controlador/comite.controlador.php";
	require_once "modelo/comite.modelo.php";

	require_once "controlador/presidente.controlador.php";
	require_once "modelo/presidente.modelo.php";

	require_once "controlador/personas.controlador.php";
	require_once "modelo/persona.modelo.php";

	require_once "controlador/direccion.controlador.php";
	require_once "modelo/direccion.modelo.php";

	require_once "controlador/socio.controlador.php";
	require_once "modelo/socio.modelo.php";

	require_once "controlador/postulante.controlador.php";
	require_once "modelo/postulante.modelo.php";

	require_once "controlador/inscripcion.controlador.php";
	require_once "modelo/inscripcion.modelo.php";

	require_once "controlador/beneficiario.controlador.php";
	require_once "modelo/beneficiario.modelo.php";

	require_once "controlador/almacen.controlador.php";
	require_once "modelo/almacen.modelo.php";

	require_once "helper/funciones.php";


	
	$plantilla = new ControladorPlantilla();
	$plantilla -> ctrPlantilla();
 ?>