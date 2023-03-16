<?php 
	require_once "controlador/plantilla.controlador.php";
	require_once "controlador/ruta.controlador.php";

	require_once "controlador/administrador.controlador.php";
	require_once "modelo/administrador.modelo.php";

	require_once "controlador/propuesta.controlador.php";
	require_once "modelo/propuesta.modelo.php";
	$plantilla = new ControladorPlantilla();
	$plantilla -> ctrPlantilla();
 ?>