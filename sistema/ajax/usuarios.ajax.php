<?php 
	require_once '../controlador/usuario.controlador.php';
	require_once '../modelo/usuario.modelo.php';

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarUsuario') {
		$respuesta = ControladorUsuario::ctrMostrarUsuario('idUsuario', $_POST['idUsuario']);
		echo json_encode($respuesta);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarUsuario') {
		$editarSocio = ControladorUsuario::ctrEditarUsuario();
		echo $editarSocio;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarImg') {
		$editarImg = ControladorUsuario::ctrEditarImg();
		echo $editarImg;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarContra') {
		$editarContra = ControladorUsuario::ctrEditarContra();
		echo $editarContra;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarEstado') {
		$idUsuario = $_POST['idusuario'];
		$estado = $_POST['estadousuario'];
		$editarEstado = ControladorUsuario::ctreditarEstado($idUsuario, $estado);
		echo $editarEstado;
	}

 ?>