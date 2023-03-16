<?php 
	require_once '../controlador/socio.controlador.php';
	require_once '../modelo/socio.modelo.php';

	require_once '../modelo/persona.modelo.php';

	require_once '../controlador/direccion.controlador.php';
	require_once '../modelo/direccion.modelo.php';

	require_once '../controlador/beneficiario.controlador.php';
	require_once '../modelo/beneficiario.modelo.php';

	require_once '../controlador/inscripcion.controlador.php';
	require_once '../modelo/inscripcion.modelo.php';

	require_once '../helper/funciones.php';

	session_start();
	Class AjaxBeneficiario{

		public function ajaxCambiarSocio(){
			$idBeneficiario = $_POST['idBeneficiario'];
			if (isset($_POST['idSocio']) && !empty($_POST['idSocio'])) {
				$idSocio = $_POST['idSocio'];
				$cambio = ControladorBeneficiario::ctrEditarCampoBeneficiario('idSocioBenef', $idSocio, $idBeneficiario);
				return $cambio;
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
					$numero = trim($_POST['txtNumeroDirSocio']);
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
	 							$cambio = ControladorBeneficiario::ctrEditarCampoBeneficiario('idSocioBenef', $idSocio, $idBeneficiario);
	 							return $cambio;
	 						}else{
	 							return 'error';
	 						}
						
					}else{
						return 'novalido';
					}
				}

			}
		}
		public function ajaxDatosBeneficiario($idBeneficiario, $idEstado){
			date_default_timezone_set('America/Lima');
			$respuesta = ControladorBeneficiario::ctrDatosBeneficiario('idInscripcionBenef', $idBeneficiario, $idEstado);
			$tiempoRestante = '';
			$fechaActual =  Date('Y-m-d');
			if ($respuesta['idEstadoBenef'] != 1) {
				$tiempoRestante = 'No calculable';
			}else if($respuesta['fechaVencimiento'] == null){
				$tiempoRestante = 'Indefinido';
				$respuesta['fechaVencimiento'] = 'Indefinido';
			}else{
				$tiempoRestante = calcularVencimiento($fechaActual, $respuesta['fechaVencimiento']);
			}
			
			$otros = array("edadPostulante" => calcularEdad($respuesta['fechaNacimiento']), "tiempoRestante" => $tiempoRestante);
			$datos = array_merge($respuesta, $otros);
			echo json_encode($datos);
		}

		public function ajaxEditarBeneficiario(){
			if (isset($_POST['cmbParentesco']) && isset($_POST['cmbEstadoBenef']) && isset($_POST['cmbComite']) &&
				isset($_POST['customRadio']) && isset($_POST['txtDescripcionBenef']) &&
				isset($_POST['idInscripcion']) && isset($_POST['idPostulante'])  &&  
				!empty($_POST['cmbEstadoBenef']) && !empty($_POST['cmbParentesco']) && 
				!empty($_POST['customRadio']) && !empty($_POST['idInscripcion']) &&
				!empty($_POST['idPostulante']) && isset($_POST['fechaRg']) && 
				!empty($_POST['fechaRg']) && isset($_POST['fechaVen']) && 
				!empty($_POST['fechaVen']) && isset($_POST['estadoBen']) && 
				!empty($_POST['estadoBen']) && !empty($_POST['cmbComite'])
			) {
				$idBeneficiario = intval($_POST['idInscripcion']);
				$idPostulante = intval($_POST['idPostulante']);
				$idTipoSocio = intval($_POST['cmbParentesco']);
				$idEstadoBenef = intval($_POST['cmbEstadoBenef']);
				$descripcion = trim($_POST['txtDescripcionBenef']);
				$estadoActual = intval($_POST['estadoBen']);
				$idComite = intval($_POST['cmbComite']);
				//date_default_timezone_set('America/Lima');
				$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
				$year = intval(date("Y", strtotime($_POST['fechaRg'])));
				$mes = intval(date('m', strtotime($_POST['fechaRg'])));
				$sexoPostulante = $_POST['customRadio'];
				$respuesta = '';
				if (preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $descripcion) || empty($descripcion)) {
					if ($estadoActual ==  2 || $estadoActual == 4) {
						if ($idEstadoBenef == 1) {
							$validar = ControladorBeneficiario::ctrVerPeriodos($idMunicipalidad, 0);
							if ($validar['total'] == 0) {
								$respuesta = 'si';
							}else{
								$respuesta = 'no';
							}
						}
					}else if($estadoActual == 1){
						if ($idEstadoBenef != $estadoActual) {
							if ($_POST['fechaVen'] == 'Indefinido') {
								$consulta = '';
							}else{
								$yearVen = intval(date("Y", strtotime($_POST['fechaVen'])));
								$mesVen = intval(date('m', strtotime($_POST['fechaVen'])));
								$consulta = 'AND mesEntrega <= '.$mesVen.' AND yearEntrega <= '.$yearVen;
							}
							$validar = ControladorBeneficiario::ctrValBenef($idMunicipalidad, $mes, $year, $consulta);
							if ($validar['total'] == 0) {
								$respuesta = 'si';
							}else{
								$respuesta = 'no';
							}
						}
					}
					if ($respuesta == '' || $respuesta == 'si') {
						if ($sexoPostulante == 'M') {
							$sexoPostulante = 'MASCULINO';
						}else if($sexoPostulante = 'F'){
							$sexoPostulante = 'FEMENINO';
						}
						$editarPostulante = ControladorInscripcion::ctrEditarPostulante($descripcion, $sexoPostulante, $idPostulante);
			 			if ($editarPostulante == 'ok') {
							$editarBeneficiario = ControladorBeneficiario::ctrEditarBeneficiario($idTipoSocio, $idEstadoBenef, $idBeneficiario, $idComite);		
							if ($editarBeneficiario == 'ok') {
								return 'ok';
							}else{
								return 'error';
							}	 				
			 			}else{
			 				return 'error';
			 			}
					}else if ($respuesta == 'no') {
						return 'no'	;
					}
				}else{
					return 'novalido';
				}
			}
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'cambiarSocio') {
		$nuevoSocio = new AjaxBeneficiario();
		echo $nuevoSocio->ajaxCambiarSocio();
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'datosBeneficiario') {
		$datosBeneficiario = new AjaxBeneficiario();
		$datosBeneficiario->ajaxDatosBeneficiario($_POST['idBeneficiario'], $_POST['idEstado']);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarBeneficiario') {
		$editarBeneficiario = new AjaxBeneficiario();
		echo $editarBeneficiario->ajaxEditarBeneficiario();
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarBenef') {
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$beneficiarios = ControladorBeneficiario::ctrMostrarBeneficiarios($idMunicipalidad, $_POST['item'], $_POST['valor'], '', '', $_POST['estado']);
		echo json_encode($beneficiarios);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarDatos') {
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$beneficiarios = ControladorBeneficiario::ctrGrficaBenef($idMunicipalidad);
		echo json_encode($beneficiarios);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'vencido') {
		$idBeneficiario = $_POST['idBeneficiario'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$validar = ControladorBeneficiario::ctrVerPeriodos($idMunicipalidad, 0);
		if ($validar['total'] == 0) {
			$beneficiarios = ControladorBeneficiario::ctrEditarCampoBeneficiario('idEstadoBenef', 3, $idBeneficiario);
			if ($beneficiarios == 'ok') {
				$respuesta = 'ok';
			}else{
				$respuesta = 'error';
			}
		}else{
			$respuesta = 'no';
		}
		echo $respuesta;
	}

 ?>