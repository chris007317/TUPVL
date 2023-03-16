<?php 
	Class ControladorPostulante{
		/*----------  Mostrar el almacen de productos  ----------*/
		static public function ctrMostrarPostulante($item, $valor){
			$respuesta = new ModeloPostulante();
			return $respuesta->mdlMostrarPostulante($item, $valor);
		}
		public function ctrRegistrarPostulante(){
			if (isset($_POST['txtApellidoPaternoPost']) && isset($_POST['txtApellidoMaternoPost']) && 
				isset($_POST['txtNombresPost']) && isset($_POST['cmbDistritoPost']) && 
				isset($_POST['customRadio']) && isset($_POST['txtDireccionPostulante']) && 
				isset($_POST['tipoSocioPost']) && isset($_POST['dateFechaNac']) &&
				isset($_POST['cmbComitesPost']) && isset($_POST['cmbTipoPostulante']) && 
				isset($_POST['txtDniPostulante']) && isset($_POST['idSocioPostulante']) &&
				isset($_POST['dateFechaRegistro']) && !empty($_POST['cmbDistritoPost']) && 
				!empty($_POST['customRadio']) && !empty($_POST['txtApellidoMaternoPost']) && 
				!empty($_POST['txtApellidoPaternoPost']) && !empty($_POST['txtNombresPost']) && 
				!empty($_POST['txtDireccionPostulante']) && !empty($_POST['dateFechaNac']) &&
				!empty($_POST['tipoSocioPost']) && !empty($_POST['cmbComitesPost']) &&
				!empty($_POST['cmbTipoPostulante']) && !empty($_POST['txtDniPostulante']) &&
				!empty($_POST['idSocioPostulante']) && !empty($_POST['dateFechaRegistro'])
			) {
				$dniPostulante = trim($_POST['txtDniPostulante']);
				$apellidoPaterno = trim($_POST['txtApellidoPaternoPost']);
				$apellidoMaterno = trim($_POST['txtApellidoMaternoPost']);
				$nombrePostulante = trim($_POST['txtNombresPost']);
				$idDistrito = intval($_POST['cmbDistritoPost']);
				$sexoPostulante = $_POST['customRadio'];
				$direccionPostulante = trim($_POST['txtDireccionPostulante']);
				$fechaNacimiento = $_POST['dateFechaNac'];
				if (preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/", $apellidoPaterno) && preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoMaterno) &&
					preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ' ]+$/", $nombrePostulante) && preg_match('/^[0-9]+$/', $dniPostulante) && 
					preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $direccionPostulante) && 
					(preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['txtDescripcionDirPost']) || empty($_POST['txtDescripcionDirPost'])) && (preg_match('/^[0-9]+$/', $_POST['txtNumeroDirPostulante']) || empty($_POST['txtNumeroDirPostulante'])) && validarFecha($fechaNacimiento) && compararFechas(date('Y-m-d'), $fechaNacimiento) &&
					(preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST['txtDescripcionPost']) || empty($_POST['txtDescripcionPost']))
				) {
					if (empty($_POST['idPersonaPostulante'])) {
						$agregarPersona = new ModeloPersona();
						$idPersona = $agregarPersona->mdlRegistrarPersona($nombrePostulante, $apellidoMaterno, $apellidoPaterno, $dniPostulante);
							if ($idPersona < 1) {
								echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar a la persona!', 'error');
								exit();
							}
					}else{
						$idPersona = $_POST['idPersonaPostulante'];
					}
					$descripcionDireccionPost = trim($_POST['txtDescripcionDirPost']);
					$numeroDireccion = intval($_POST['txtNumeroDirPostulante']);
					if (empty($_POST['idDireccionPostulante'])){
						$agregarDireccion = new ModeloDireccion();
				 		$idDireccion = $agregarDireccion->mdlAgregarDireccion($direccionPostulante, $numeroDireccion, $descripcionDireccionPost, $idDistrito);
					 		if ($idDireccion > 0) {
								$editarDireccion = new ModeloPersona();
			 					$socioDir = $editarDireccion->mdlEditarCampoPersona('idDireccion', $idDireccion, $idPersona);
			 					if (!$socioDir) {
			 						echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar la dirección de la persona!', 'error');
			 						exit();
			 					}
					 		}
					}else{
						$idDireccion = $_POST['idDireccionPostulante'];
						$editarDireccion = new ModeloDireccion();
				 		$respuesta = $editarDireccion->mdlEditarDireccion($direccionPostulante, $numeroDireccion, $descripcionDireccionPost, $idDistrito, $idDireccion);
				 		if (!$respuesta) {
				 			echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar la dirección de la persona!', 'error');
	 						exit();
				 		}
					}
					$descripcionPostulante = $_POST['txtDescripcionPost'];
					if ($sexoPostulante == 'M') {
						$sexoPostulante = 'MASCULINO';
					}else if($sexoPostulante = 'F'){
						$sexoPostulante = 'FEMENINO';
					}
					if (empty($_POST['idPost'])) {
						$agregarPostulante = new ModeloPostulante();
						$idPostulante = $agregarPostulante->mdlRegistrarPostulante($fechaNacimiento, $sexoPostulante, $descripcionPostulante, $idPersona);
							if ($idPostulante < 1) {
								echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar al postulante!', 'error');
								exit();
							}
					}else{
						$idPostulante = $_POST['idPost'];
						$editarPostulante = new ModeloPostulante();
				 		$respuesta = $editarPostulante->mdlEditarPostulante($sexoPostulante, $descripcionPostulante, $idPostulante);
				 		if (!$respuesta) {
				 			echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar los datos del postulante!', 'error');
	 						exit();
				 		}
					}
					$fechaRegistro = str_replace('T', ' ', $_POST['dateFechaRegistro']);
					$idComite = intval($_POST['cmbComitesPost']);
					$idSocioPostulante = intval($_POST['idSocioPostulante']);
					$idTipoSocio = intval($_POST['tipoSocioPost']);	
					$idTipoPostulante = intval($_POST['cmbTipoPostulante']);
					$idUsuario = $_SESSION['idUsuarioPvl'];
					if (!empty($idPostulante)) {
						$agregarInscripcion = new ModeloInscripcion();
						$idInscripcion = $agregarInscripcion->mdlRegistrarInscripcion($fechaRegistro, $idPostulante, $idComite, $idSocioPostulante, $idTipoSocio, $idTipoPostulante, $idUsuario);
						if ($idInscripcion > 0) {
							for ($i = 1; $i <= $_POST['totalReq']; $i++) { 
								if(isset($_POST['checkRequisto'.$i])){
									$idRequisito = $_POST['checkRequisto'.$i];	
									$nuevoRequsito = new ModeloInscripcion();
									$agregarRequisito = $nuevoRequsito->mdlRegistrarRequisito($idInscripcion, $idRequisito);
								}
							}
							echo mensajeImprimir('¡CORRECTO!', 'El postulante fue registrados con exito, ¿desea Imprimir la ficha?', 'success', $idPostulante, $idInscripcion);
					 	}else{
					 		echo mensajeRecarga('¡ERROR!', '¡Ocurrio un error al momento de registrar al postulante!', 'error');	
					 	}
					}else{
						echo mensajeRecarga('¡ERROR!', '¡Ocurrio un error al momento de registrar al postulante!', 'error');							
					}

				}else{
					echo mensajeRecarga('¡ERROR!', '¡Los datos no deben contener caracteres especiales!', 'error');	
				}
			}
		}

		/*----------  Mostrar postulantes  ----------*/
		static public function ctrMostrarPostulantes($fechaInicio, $fechaFin, $idMunicipalidad, $estado){
			$respuesta = new ModeloPostulante();
			return $respuesta->mdlMostrarPostulantes($fechaInicio, $fechaFin, $idMunicipalidad, $estado);
		}
		static public function ctrConsultaPostulante($idMunicipalidad, $dni){
			$respuesta = new ModeloPostulante();
			return $respuesta->mdlConsultaPostulante($idMunicipalidad, $dni);
		} 
		/*----------  Consultar reporte de postulantes  ----------*/
		static public function ctrReportePostulante($idMunicipalidad){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlReportePostulante($idMunicipalidad);	
		}
	}