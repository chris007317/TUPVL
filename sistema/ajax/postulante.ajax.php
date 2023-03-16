<?php 
	require_once '../controlador/inscripcion.controlador.php';
	require_once '../modelo/inscripcion.modelo.php';

	require_once '../controlador/postulante.controlador.php';
	require_once '../modelo/postulante.modelo.php';

	require_once '../controlador/requisito-municipalidad.controlador.php';
	require_once '../modelo/requisito-municipalidad.modelo.php';

	require_once '../controlador/beneficiario.controlador.php';
	require_once '../modelo/beneficiario.modelo.php';
 
	require_once '../modelo/tipo-beneficiario.modelo.php';

	require_once '../helper/funciones.php';
	
	date_default_timezone_set('America/Lima');
	session_start();
	Class AjaxPostulante{
		/*----------  editar estado proveedor  ----------*/
		public function ajaxEditarPostulante(){
			if (isset($_POST['cmbComite']) && isset($_POST['customRadio']) && 
				isset($_POST['txtDescripcionPost']) && isset($_POST['idInscripcion']) && 
				isset($_POST['idPostulante'])  && !empty($_POST['cmbComite']) && 
				!empty($_POST['customRadio']) && !empty($_POST['idInscripcion']) && !empty($_POST['idPostulante'])) {
				$idInscripcion = intval($_POST['idInscripcion']);
				$idPostulante = intval($_POST['idPostulante']);
				$idComite = intval($_POST['cmbComite']);
				$descripcion = trim($_POST['txtDescripcionPost']);
				if ($_POST['customRadio'] == 'M') {
					$sexo = 'MASCULINO';
				}else if($_POST['customRadio'] == 'F'){
					$sexo = 'FEMENINO';
				}
				if (preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $descripcion) || empty($descripcion)){
					$item = 'idComiteInscripcion';
					$inscripcion = ControladorInscripcion::ctrEditarInscripcion($item, $idComite, $idInscripcion);
					$postulante = ControladorInscripcion::ctrEditarPostulante($descripcion, $sexo, $idPostulante);
					if ($inscripcion =='ok' && $postulante == 'ok') {
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

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarInscripcion') {
		$proveedor = new AjaxPostulante();
		echo $proveedor->ajaxEditarPostulante();
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarInscripcionPost') {
		$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
		$postulante = ControladorPostulante::ctrMostrarPostulante('idPostulante', $_POST['idPostulante']);
		$requisitos = ControladorRequisitoMunicipalidad::ctrMostrarRequisitoMunicipalidad($idMunicipalidad, $_POST['idTipoInscripcion']);
		$reqCumplidos = ControladorInscripcion::ctrMostrarRequisitosInscripcion($_POST['idInscripcion']);
		$benef = new ModeloTipoBeneficiario();
		$tipoBenef = $benef->mdlMostrarTipoBeneficiario('idTipoBeneficiario', $_POST['idTipoInscripcion']);
		$idTipoInscripcion = $_POST['idTipoInscripcion'];
		$checkList = '';
		$totalRequisitos = count($requisitos);
		$req = 0;
		$contarRequisito = 0;
		for ($i = 0; $i < $totalRequisitos; $i++) { 
			for ($j = 0; $j < count($reqCumplidos); $j++) { 
				if ($requisitos[$i]['idReMuni'] == $reqCumplidos[$j]['idReMuni']) {
					$req++;
					break;
				}
			} 
			if ($req > 0) {
				$checkList .="<div class='custom-control custom-checkbox'><input class='custom-control-input' type='checkbox' value='".$requisitos[$i]['idReMuni']."' checked='true' disabled><label class='custom-control-label'>".$requisitos[$i]['nombreRequisito']."</label></div>";
				$req = 0;
				$contarRequisito++;
			}else{
				$checkList .="<div class='custom-control custom-checkbox'><input class='custom-control-input checkRequisito' type='checkbox' id='checkRequisto".($i+1)."' name='checkRequisto".($i+1)."' value='".$requisitos[$i]['idReMuni']."'><label for='checkRequisto".($i+1)."' class='custom-control-label'>".$requisitos[$i]['nombreRequisito']."</label></div>";
			}
		}
		$template = "<div class='w-60'><strong>Requisitos</strong><div class='' id='requisitos'>".$checkList."</div></div><div class='w-40'><strong>Total de requisitos: <span>".$totalRequisitos."</span></strong><h5><span class='badge badge-info' id='numRequisitos'></span></h5></div>";
		$reqList = array("reqList" => $template, "totalRequisitos" => $totalRequisitos, "edadPostulante" => calcularEdad($postulante['fechaNacimiento']), 'nombreTipoBeneficiario' => $tipoBenef['nombreTipoBeneficiario'], "finEdad"=>$tipoBenef['finEdad'], "edadMeses"=>calcularMeses($postulante['fechaNacimiento']), "contarRequisito" => $contarRequisito, "idTipoInscripcion" => $idTipoInscripcion, 'tiempoMeses' => $tipoBenef['tiempoMeses']);
		$datos = array_merge($postulante, $reqList);	
		echo json_encode($datos);
	}

		
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'rechazarAceptarPost') {
		$idPostulante = $_POST['idPost'];
		$idInscripcion = $_POST['idIns'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$beneficiario = ControladorBeneficiario::ctrMostrarBeneficiario('idPostBenef', $idPostulante);
		$respuesta = '';
		date_default_timezone_set('America/Lima');
      	if (!empty($beneficiario)) {
    		$respuesta = 'existe';
	    }else{
	      	$totalRequisitos = $_POST['totalReq'];
	      	if ($totalRequisitos > 0) {
		        for ($i = 1; $i <= $totalRequisitos; $i++) { 
	          		if(isset($_POST['checkRequisto'.$i])){
			            $idRequisito = $_POST['checkRequisto'.$i];  
			            $nuevoRequsito = new ModeloInscripcion();
			            $agregarRequisito = $nuevoRequsito->mdlRegistrarRequisito($idInscripcion, $idRequisito);
		          }
		        }
	      	}
	      	$inscripcion = ControladorInscripcion::ctrMostrarInscripcion('idInscripcion', $idInscripcion);
	      	if ($inscripcion['idPostulante'] == $idPostulante) {
	        	$idUsuario = $_SESSION['idUsuarioPvl'];
	        	$fechaReg = $_POST['fechaReg'];
	        	$fechaInicio = '';
				$fechaVen = null;
				if ($_POST['mesesMaximo'] > 0) {
					if (!isset($_POST['txtMeses']) && !isset($_POST['txtDias'])) {
						$fechaInicio = $_POST['fechaNacPost'];
					}else if($_POST['txtMeses'] < $_POST['mesesMaximo']){
						$fechaInicio = calcularTiempo($_POST['txtMeses'], $_POST['txtDias']);
					}else{
						echo 'novalido';
						exit();
					}
					$fechaVen = calcularFechaVencimiento($fechaInicio, $_POST['mesesMaximo']);
				}
				$fechaActual = date('Y-m-d');
				if ($fechaVen > $fechaActual ) {
					$year = intval(date("Y", strtotime($fechaActual)));
					$mes = intval(date('m', strtotime($fechaActual)));
					$validar = ControladorBeneficiario::ctrValBenef($idMunicipalidad, $mes, $year, '');
					if ($validar['total'] == 0) {
						$inscripcionBeneficiario = ControladorBeneficiario::ctrAgregarBeneficiario($idPostulante, $inscripcion['idTipoInscripcion'], $inscripcion['idSocioInscripcion'], $inscripcion['idTipoSo'], 1, $inscripcion['idComiteInscripcion'], $idUsuario, $fechaReg, $fechaVen);
			            if ($inscripcionBeneficiario > 0) {
			                  $editarInscripcion = ControladorInscripcion::ctrEditarInscripcion('estadoInscripcion', 2, $idInscripcion);
			                if ($editarInscripcion) {
			                  $respuesta = 'ok';
			                }else{
			                  $respuesta = 'error';
			                }
			            }else{
			                $respuesta = 'error';
			            }
					}else{
						$respuesta = 'no';
					}
				}else{
					$respuesta ='noval';
				}
      		}else{
	        	$respuesta = 'error';
	  		}
    	}
    	echo $respuesta;
		exit();
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarEstado') {
		$idInscripcion = $_POST['idInscripcion'];
		$estado = $_POST['estado'];
		$editarInscripcion = ControladorInscripcion::ctrEditarInscripcion('estadoInscripcion', $estado, $idInscripcion);
		$respuesta = '';
		if ($editarInscripcion) {
			$respuesta = 'ok';
		}else{
			$respuesta = 'error';
		}
		echo $respuesta;
		exit();
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'contar') {
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$respuesta = ControladorInscripcion::ctrPorcentajeInscritos($idMunicipalidad,$_POST['estado']);
		echo json_encode($respuesta);
	}