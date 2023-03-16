<?php 
	require_once "controlador/plantilla.controlador.php";
	require_once "controlador/ruta.controlador.php";

	require_once "controlador/inscripcion.controlador.php";
	require_once "modelo/inscripcion.modelo.php";
	
	$plantilla = new ControladorPlantilla();
	$plantilla -> ctrPlantilla();
 ?>