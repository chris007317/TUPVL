<?php 
	require_once '../controlador/direccion.controlador.php';
	require_once '../modelo/direccion.modelo.php';

	require_once '../modelo/persona.modelo.php';

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'agregarDireccion') {
		$agregarDireccion = ControladorDireccion::ctrAgregarDirección();
		if ($agregarDireccion > 0) {
			$idDireccion = $agregarDireccion;
			$editarDireccion = new ModeloPersona();
		 	$respuesta = $editarDireccion->mdlEditarCampoPersona('idDireccion', $idDireccion, $_POST['idPersona']);
		 	if ($respuesta) {
		 		echo "ok";
		 	}else{
		 		echo "error";
		 	}
		}else{
			echo $agregarDireccion;
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarDireccion') {
		$respuesta = ControladorDireccion::ctrEditarDireccion();
		if ($respuesta) {
			echo "ok";
		}else{
			echo "error";
		}
		
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarProvincias') {
		$respuesta = ControladorDireccion::ctrMostrarProvincias($_POST['idDepartamento']);
		echo json_encode($respuesta);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarDistritos') {
		$respuesta = ControladorDireccion::ctrMostrarDistritos($_POST['idProvincia']);
		echo json_encode($respuesta);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDireccion') {
		$respuesta = ControladorDireccion::ctrMostrarDireccion($_POST['idDireccion']);
		echo json_encode($respuesta);
	}

 ?>