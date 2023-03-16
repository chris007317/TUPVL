<?php 
	require_once '../controlador/socio.controlador.php';
	require_once '../modelo/socio.modelo.php';

	require_once '../modelo/persona.modelo.php';

	require_once '../controlador/direccion.controlador.php';
	require_once '../modelo/direccion.modelo.php';

	session_start();
	Class AjaxSocio{
		/*----------  Mostrar dato de un solo presidente  ----------*/
		public function ajaxAgregarSocio(){
			if (isset($_POST['txtDniSocio']) && isset($_POST['txtApellidoPaterno']) &&
				isset($_POST['txtApellidoMaterno']) && isset($_POST['txtNombreSocio']) &&
				isset($_POST['cmbDistritoDir']) && isset($_POST['txtDireccionSocio']) &&
				!empty($_POST['txtDniSocio']) && !empty($_POST['txtApellidoPaterno']) &&
				!empty($_POST['txtApellidoMaterno']) && !empty($_POST['txtNombreSocio']) &&
				!empty($_POST['cmbDistritoDir']) && !empty($_POST['txtDireccionSocio'])
			) {
			
				$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
				$apellidoPaterno = trim($_POST['txtApellidoPaterno']);
				$apellidoMaterno = trim($_POST['txtApellidoMaterno']);
				$nombres = trim($_POST['txtNombreSocio']);
				$dni = trim($_POST['txtDniSocio']);
				$idDistrito = intval($_POST['cmbDistritoDir']);
				$direccion = trim($_POST['txtDireccionSocio']);
				$numero = trim($_POST['txtNumeroDir']);
				$descripcionDir = trim($_POST['txtDescripcionDir']);
				$verSocio = ControladorSocio::ctrMostrarSocio('dniPersona', $dni, $idMunicipalidad);
				if (!empty($verSocio)) {
					return 'existe';
				}else if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoPaterno) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoMaterno) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombres) && 
					preg_match('/^[0-9]+$/', $dni) && (preg_match('/^[0-9]+$/', $_POST['txtCelularSocio']) || empty($_POST['txtCelularSocio'])) && 
					(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['txtCorreoSocio']) || empty($_POST['txtCorreoSocio'])) &&
						preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $direccion) && (preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $descripcionDir) || empty($descripcionDir))
				){
					if (empty($_POST['idPersonaSocio'])) {
						$agregarPersona = new ModeloPersona();
						$idPersona = $agregarPersona->mdlRegistrarPersona($nombres, $apellidoMaterno, $apellidoPaterno, $dni);
						if ($idPersona < 1) {
							return 'error';
							exit();
						}
					}else{
						$idPersona = $_POST['idPersonaSocio'];
					}
					if (empty($_POST['idDireccionSocio'])) {
						$agregarDireccion = new ModeloDireccion();
				 		$idDireccion = $agregarDireccion->mdlAgregarDireccion($direccion, $numero, $descripcionDir, $idDistrito);
				 		if ($idDireccion > 0) {
							$editarDireccion = new ModeloPersona();
		 					$socioDir = $editarDireccion->mdlEditarCampoPersona('idDireccion', $idDireccion, $idPersona);
		 					if (!$socioDir) {
		 						return 'error';
		 						exit();
		 					}
				 		}
					}else{
						$idDireccion = $_POST['idDireccionSocio'];
					}
					$idSocio = ControladorSocio::ctrAgregarSocio($_POST['txtCorreoSocio'], $_POST['txtCelularSocio'], intval($idPersona), intval($idMunicipalidad));
 						if ($idSocio > 0) {
 							return 'ok';
 						}else{
 							return 'error';
 						}
					
				}else{
					return 'novalido';
				}

			}
		}

		public function ajaxMostrarSocio($idSocio, $idMunicipalidad){
			$verSocio = ControladorSocio::ctrMostrarSocio('idSocio', $idSocio, $idMunicipalidad);
			$direccion = ControladorDireccion::ctrMostrarDireccion($verSocio['idDireccion']);
			$datos = array_merge($verSocio, $direccion);
			echo json_encode($datos);
		}

		public function ajaxCambiarSocio(){
			if (isset($_POST['idSocio']) && !empty($_POST['idSocio'])) {
				$idSocio = $_POST['idSocio'];
			}else{
				if (isset($_POST['txtDniSocio']) && isset($_POST['txtApellidoPaterno']) &&
					isset($_POST['txtApellidoMaterno']) && isset($_POST['txtNombreSocio']) &&
					isset($_POST['cmbDistritoSocio']) && isset($_POST['txtDireccionSocio']) &&
					!empty($_POST['txtDniSocio']) && !empty($_POST['txtApellidoPaterno']) &&
					!empty($_POST['txtApellidoMaterno']) && !empty($_POST['txtNombreSocio']) &&
					!empty($_POST['cmbDistritoSocio']) && !empty($_POST['txtDireccionSocio'])
				) {
					$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
					$apellidoPaterno = trim($_POST['txtApellidoPaterno']);
					$apellidoMaterno = trim($_POST['txtApellidoMaterno']);
					$nombres = trim($_POST['txtNombreSocio']);
					$dni = trim($_POST['txtDniSocio']);
					$idDistrito = intval($_POST['cmbDistritoSocio']);
					$direccion = trim($_POST['txtDireccionSocio']);
					$numero = trim($_POST['txtNumeroDir']);
					$descripcionDir = trim($_POST['txtDescripcionDirSocio']);
					if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoPaterno) &&
						preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoMaterno) &&
						preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombres) && 
						preg_match('/^[0-9]+$/', $dni) && (preg_match('/^[0-9]+$/', $_POST['txtCelularSocio']) || empty($_POST['txtCelularSocio'])) && 
						(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['txtCorreoSocio']) || empty($_POST['txtCorreoSocio'])) &&
							preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $direccion) && (preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $descripcionDir) || empty($descripcionDir))
					){
						if (empty($_POST['idPersonaSocio'])) {
							$agregarPersona = new ModeloPersona();
							$idPersona = $agregarPersona->mdlRegistrarPersona($nombres, $apellidoMaterno, $apellidoPaterno, $dni);
							if ($idPersona < 1) {
								return 'error';
								exit();
							}
						}else{
							$idPersona = $_POST['idPersonaSocio'];
						}
						if (empty($_POST['idDireccionSocio'])) {
							$agregarDireccion = new ModeloDireccion();
					 		$idDireccion = $agregarDireccion->mdlAgregarDireccion($direccion, $numero, $descripcionDir, $idDistrito);
					 		if ($idDireccion > 0) {
								$editarDireccion = new ModeloPersona();
			 					$socioDir = $editarDireccion->mdlEditarCampoPersona('idDireccion', $idDireccion, $idPersona);
			 					if (!$socioDir) {
			 						return 'error';
			 						exit();
			 					}
					 		}
						}else{
							$idDireccion = $_POST['idDireccionSocio'];
						}
						$idSocio = ControladorSocio::ctrAgregarSocio($_POST['txtCorreoSocio'], $_POST['txtCelularSocio'], $idPersona, $idMunicipalidad);
	 						if ($idSocio > 0) {
	 							return 'ok';
	 						}else{
	 							return 'error';
	 						}
						
					}else{
						return 'novalido';
					}

				}

			}
		}
		/*----------  editar estado socio  ----------*/
		public function ajaxEstadoSocio($estado, $idSocio){
			$contar = ControladorSocio::ctrContarBenefPorSocio($idSocio);
			$respuesta = '';
			if ($contar['total'] > 0) {
				$respuesta = 'error';
			}else{
				$item = 'estadoSocio';
				$respuesta = ControladorSocio::ctrEditarCampoSocio($item, $estado, $idSocio);
			}
			echo $respuesta;
		}
	}
		
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'agregarSocio') {
		$nuevoSocio = new AjaxSocio();
		echo $nuevoSocio->ajaxAgregarSocio();;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarSocio') {
		$idSocio = $_POST['idSocio'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$nuevoSocio = new AjaxSocio();
		$nuevoSocio->ajaxMostrarSocio($idSocio, $idMunicipalidad);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'cambiarSocio') {
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$nuevoSocio = new AjaxSocio();
		$nuevoSocio->ajaxMostrarSocio($idSocio, $idMunicipalidad);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarSocio') {
		$editarSocio = ControladorSocio::ctrEditarSocioDatos();
		echo $editarSocio;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarEstado') {
		$idSocio = $_POST['idSocio'];
		$estado = $_POST['estadoSocio'];
		$proveedor = new AjaxSocio();
		$proveedor->ajaxEstadoSocio($estado, $idSocio);
	}
 ?>