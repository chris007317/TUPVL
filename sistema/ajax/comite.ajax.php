<?php 
	require_once '../controlador/comite.controlador.php';
	require_once '../modelo/comite.modelo.php';

	require_once '../controlador/presidente.controlador.php';
	require_once '../modelo/presidente.modelo.php';

		require_once '../controlador/beneficiario.controlador.php';
	require_once '../modelo/beneficiario.modelo.php';
	session_start();
	Class AjaxComite{
		/*----------  buscar localidades por municipalidad  ----------*/
		public function ajaxComiteLocalidad($idMunicipalidad, $idLocalidad){
			$respuesta = ControladorComite::ctrMostrarComitesLocalidad($idMunicipalidad, $idLocalidad);
			if (count($respuesta) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($respuesta as $key => $value) {
					$presidentes = ControladorPresidente::ctrMostrarPresidente('idComitePresidente', $value['idComite']);
					if (empty($presidentes)) {
						$presidente = "<div class='text-center'><button class='btn btn-info btn-sm text-white btnAgregarPresidente'  idComite='".$value['idComite']."' data-toggle='modal' data-target='#agregarPresidente'><i class='fas fa-plus'></i> Agregar nueva presidenta</button></div>";
						$acciones = "<div class='btn-group'>";
					}else{
						$presidente = $presidentes['apellidoPaternoPersona'].' '.$presidentes['apellidoMaternoPersona'].', '.$presidentes['nombrePersona'];
						$acciones = "<div class='btn-group'><button class='btn btn-danger btn-sm cambiarPresidente' title='Cambiar presidente' idComite='".$value['idComite']."' idPresidente='".$presidentes['idPresidente']."' data-toggle='modal' data-target='#agregarPresidente'><i class='fas fa-user-plus'></i></button><button class='btn btn-primary btn-sm editarPresidente' title='Editar Presidente' idPresidente='".$presidentes['idPresidente']."' data-toggle='modal' data-target='#agregarPresidente'><i class='fas fa-user-edit'></i></button>";
					}
					$acciones .= "<button class='btn btn-success btn-sm editarComite' title='Editar Comité' data-toggle='modal' data-target='#agregarComite' idComite='".$value['idComite']."'><i class='fas fa-pencil-alt'></i></button></div>"; 
					if ($value['estadoComite'] == 1) {
						$estado = "<div class='text-center'><button class='btn btn-warning btn-sm text-white btnActivarComite' estadoComite='0' idComite='".$value['idComite']."'>Activo</button></div>";
					}else{
						$estado = "<div class='text-center'><button class='btn btn-secondary btn-sm text-white btnActivarComite' estadoComite='1' idComite='".$value['idComite']."'>Inactivo</button></div>";
					}
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombreLocalidad'].'",
							"'.$value['nombreComite'].'",
							"'.$value['direccionComite'].' N° '.$value['numeroCalle'].'",
							"'.$value['descripcionComite'].'",
							"'.$presidente.'",
							"'.$estado.'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				echo $datosJson;
			}
		}
		/*----------  editar estado comite  ----------*/
		public function ajaxEstadoComite($estado, $idComite){
			$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
			$validar = ControladorBeneficiario::ctrVerPeriodos($idMunicipalidad, 0);
			if ($validar['total'] == 0) {
				$item = 'estadoComite';
				$respuesta = ControladorComite::ctrEditarCampoComite($item, $estado, $idComite);
				echo $respuesta;
			}else{
				echo 'no';
			}
		}
		/*----------  Mostrar dato de un solo comite  ----------*/
		public function ajaxMostrarComite($idComite){
			$respuesta = ControladorComite::ctrMostrarComite($idComite);
			echo json_encode($respuesta);
		}
		/*----------  contar comites activos  ----------*/
		public function ajaxContarComites($idMunicipalidad){
			$respuesta = ControladorComite::ctrContarComite($idMunicipalidad);
			echo json_encode($respuesta);
		}
		public function ajaxMostarComites($idMunicipalidad, $idLocalidad){
			$respuesta = ControladorComite::ctrMostrarComitesLocal($idMunicipalidad, $idLocalidad);
			echo json_encode($respuesta);
		}
	}		

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarComiteLocalidad') {
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$idLocalidad = $_POST['idLocalidad'];
		$propuestas = new AjaxComite();
		$propuestas->ajaxComiteLocalidad($idMunicipalidad, $idLocalidad);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarEstado') {
		$idComite = $_POST['idComite'];
		$estado = $_POST['estadoComite'];
		$proveedor = new AjaxComite();
		$proveedor->ajaxEstadoComite($estado, $idComite);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarComite') {
		$idComite = $_POST['idComite'];
		$proveedor = new AjaxComite();
		$proveedor->ajaxMostrarComite($idComite);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'contarComiteActivos') {
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$proveedor = new AjaxComite();
		$proveedor->ajaxContarComites($idMunicipalidad);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarComites') {
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$idLocalidad = $_POST['idLocalidad'];
		$propuestas = new AjaxComite();
		$propuestas->ajaxMostarComites($idMunicipalidad, $idLocalidad);
	}