<?php 
	require_once '../controlador/comite.controlador.php';
	require_once '../modelo/comite.modelo.php';

	require_once '../controlador/presidente.controlador.php';
	require_once '../modelo/presidente.modelo.php';
	session_start();
	Class TablaComites{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
			$comites = ControladorComite::ctrMostrarComites($idMunicipalidad);
			if (count($comites) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($comites as $key => $value) {
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
	}

	$planes = new TablaComites();
	$planes->mostrarTabla();