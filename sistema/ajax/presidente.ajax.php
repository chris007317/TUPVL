<?php 
	require_once '../controlador/presidente.controlador.php';
	require_once '../modelo/presidente.modelo.php';
	session_start();
	Class AjaxPresidente{
		/*----------  Mostrar dato de un solo presidente  ----------*/
		public function ajaxMostrarPresidente($idPresidente){
			$respuesta = ControladorPresidente::ctrMostrarPresidente('idPresidente', $idPresidente);
			echo json_encode($respuesta);
		}
	}
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarPresidente') {
		$idPresidente = $_POST['idPresidente'];
		$proveedor = new AjaxPresidente();
		$proveedor->ajaxMostrarPresidente($idPresidente);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'contar') {
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$respuesta = ControladorPresidente::ctrContarPresidentes($idMunicipalidad);
		echo json_encode($respuesta);
	}
 ?>