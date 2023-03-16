<?php 
date_default_timezone_set('America/Lima');
	Class ControladorBeneficiario{
		/*----------  Mostrar el almacen de productos  ----------*/
		static public function ctrMostrarBeneficiario($item, $valor){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlMostrarBeneficiario($item, $valor);
		}
		/*----------  Agregar nuevo beneficiario  ----------*/
		static public function ctrAgregarBeneficiario($idPostulante, $idTipoBeneficiario, $idSocioBeneficiario, $idTipoSocio, $idEstado, $idComiteBeneficiario, $idUsuario, $fechaRegistro, $fechaVencimiento){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlAgregarBeneficiario($idPostulante, $idTipoBeneficiario, $idSocioBeneficiario, $idTipoSocio, $idEstado, $idComiteBeneficiario, $idUsuario, $fechaRegistro, $fechaVencimiento);	
		}
		/*----------  Agregar nuevo beneficiario  ----------*/
		public function ctrRegistrarBeneficiario(){
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
					$beneficiario = ControladorBeneficiario::ctrMostrarBeneficiario('dniPersona ', $dniPostulante);
					$respuesta = '';
					date_default_timezone_set('America/Lima');
			      	if (!empty($beneficiario)) {
			    		$respuesta = 'existe';
				    }else{
				    	$idTipoPostulante = intval($_POST['cmbTipoPostulante']);
				    	$fechaInicio = '';
				    	$fechaVen = null;
			    		$mesesMaximo = intval($_POST['mesesMaximo']); 
				    	/*----------  Calcular fecha de vencimiento por tipo de beneficiario  ----------*/
				    	if ($idTipoPostulante == 1 || $idTipoPostulante ==  4 ) {
				    		$tiempoMeses = intval($_POST['txtMeses']);
				    		$tiempoDias = intval($_POST['txtDias']);
				    		 if($tiempoMeses < $mesesMaximo){
								$fechaInicio = calcularTiempo($tiempoMeses, $tiempoDias);
							}else{
								echo mensaje('¡ERROR!', '¡Ocurrio un error al ingresar el tiempo de vida del bebé!', 'error');
								exit();
							}
							$fechaVen = calcularFechaVencimiento($fechaInicio, $mesesMaximo);
				    	}else if($idTipoPostulante == 2 || $idTipoPostulante == 3){
				    		$fechaInicio = $fechaNacimiento;
				    		$fechaVen = calcularFechaVencimiento($fechaInicio, $mesesMaximo);
				    	}
				    	/*----------  Registrar datos personales del beneficiario  ----------*/
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
						$idUsuario = $_SESSION['idUsuarioPvl'];
						if (!empty($idPostulante)) {
							$inscripcionBeneficiario = ControladorBeneficiario::ctrAgregarBeneficiario($idPostulante, $idTipoPostulante, $idSocioPostulante, $idTipoSocio, 1, $idComite, $idUsuario, $fechaRegistro, $fechaVen);
							if ($inscripcionBeneficiario > 0) { 
								echo mensajeRecarga('¡CORRECTO!', 'El beneficiario fue registrado con exito', 'success');
						 	}else{
						 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar al postulante!', 'error');	
						 	}
						}else{
							echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar al postulante!', 'error');							
						}
				    }



				}else{
					echo mensaje('¡ERROR!', '¡Los datos no deben contener caracteres especiales!', 'error');	
				}
			}
		}
		/*----------  Mostrar beneficiarios  ----------*/
		static public function ctrMostrarBeneficiarios($idMunicipalidad, $item, $valor, $fechaInicio, $fechaFin, $idEstado){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlMostrarBeneficiarios($idMunicipalidad, $item, $valor, $fechaInicio, $fechaFin, $idEstado);
		}

		/*----------  editar un solo campo de un beneficiario  ----------*/
		static public function ctrEditarCampoBeneficiario($item, $valor, $idBeneficiario){
			$respuesta = new ModeloBeneficiario();
			$editar = $respuesta->mdlEditarCampoBeneficiario($item, $valor, $idBeneficiario);	
			if($editar){
				return 'ok';
			}
		}

		/*----------  datos del beneficiario  ----------*/
		static public function ctrDatosBeneficiario($item, $valor, $idEstado){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlDatosBeneficiario($item, $valor, $idEstado);
		}
		/*----------  mostrar estado de los beneficiario  ----------*/
		static public function ctrMostrarEstadoBeneficiario(){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlMostrarEstadoBeneficiario();
		}
		/*----------  editar campos de un beneficiario  ----------*/
		static public function ctrEditarBeneficiario($idTipoSocio, $idEstado, $idBeneficiario, $idcomite){
			$respuesta = new ModeloBeneficiario();
			$editar = $respuesta->mdlEditarBeneficiario($idTipoSocio, $idEstado, $idBeneficiario, $idcomite);	
			if($editar){
				return 'ok';
			}	
		}

		/*----------  contar todas las inscripciones  ----------*/
		static public function ctrTotalBeneficiarios($idMunicipalidad, $estado){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlTotalBeneficiarios($idMunicipalidad, $estado);
		}

		/*----------  contar todas las inscripciones  ----------*/
		static public function ctrContarBenerfPorVencer($idMunicipalidad){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlContarBenefPorVencer($idMunicipalidad);
		}
		/*----------  mostrar los periodos  ----------*/
		static public function ctrMostrarBeneficiariosMes($idMunicipalidad, $estado){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlMostrarBeneficiariosMes($idMunicipalidad, $estado); 
		}
						/*----------  mostrar los periodos  ----------*/
		static public function ctrMostrarBeneficiariosMesVal($idMunicipalidad, $estado, $mes, $year){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlMostrarBeneficiariosMesVal($idMunicipalidad, $estado, $mes, $year); 
		}
				/*----------  mostrar los periodos  ----------*/
		static public function ctrTotalBeneficiariosActivosMes($idMunicipalidad, $mes, $year, $estado){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlTotalBeneficiariosActivosMes($idMunicipalidad, $mes, $year, $estado); 
		}
		static public function ctrContarPorMes($idMunicipalidad, $mes, $year, $estado){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlContarPorMes($idMunicipalidad, $mes, $year, $estado);
		}

		static function ctrContarBeneficiarioComites($idMunicipalidad, $mes, $year){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlContarBeneficiarioComites($idMunicipalidad, $mes, $year);
		}

		static public function ctrConsultaBeneficiario($idMunicipalidad, $dni){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlConsultaBeneficiario($idMunicipalidad, $dni);
		} 
		/*----------  Consultar reporte de beneficiarios  ----------*/
		static public function ctrReporteBeneficiario($idMunicipalidad){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlReporteBeneficiario($idMunicipalidad);	
		}
		static public function ctrGrficaBenef($idMunicipalidad){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlGrficaBenef($idMunicipalidad);		
		}
		static public function ctrValBenef($idMunicipalidad, $mes, $year, $consulta){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlValBenef($idMunicipalidad, $mes, $year, $consulta );		
		}

		static public function ctrVerPeriodos($idMunicipalidad, $estado){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlVerPeriodos($idMunicipalidad, $estado);		
		}
		/*----------  mostrar beneficiarios para realizar el padron  ----------*/
		static public function ctrBenefPadron($idComite, $mes, $year){
			$respuesta = new ModeloBeneficiario();
			return $respuesta->mdlBenefPadron($idComite, $mes, $year);
		}
		
	} 