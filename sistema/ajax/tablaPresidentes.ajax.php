<?php 
	require_once '../controlador/presidente.controlador.php';
	require_once '../modelo/presidente.modelo.php';
	session_start();
	Class TablaPresidentes{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
			$presidentes = '';
			if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarLocalidad') {
				$presidentes = ControladorPresidente::ctrMostrarPresidentes('idLocalidad', $_POST['idLocalidad'], $idMunicipalidad);	
			}else if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarActivos') {
				$presidentes = ControladorPresidente::ctrMostrarPresidentes('estadoPresidente', $_POST['estado'], $idMunicipalidad);	
			}else{
				$presidentes = ControladorPresidente::ctrMostrarPresidentes('', '', $idMunicipalidad);
			}
			if (count($presidentes) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($presidentes as $key => $value) {
					if ($value['idDireccion'] == null) {
						$direccion = "<div class='text-center'><button class='btn btn-info btn-sm text-white btnAgregarDireccion'  idPersona='".$value['idPersonaPresidente']."' data-toggle='modal' data-target='#modalDireccion'>Agregar</button></div>";
						$acciones = "<div class='btn-group'>";
					}else{
						$direccion = $value['nombreDireccion'].' N° '.$value['numero'];
						$acciones = "<div class='btn-group'><button class='btn btn-primary btn-sm editarDireccion' idDireccion='".$value['idDireccion']."' idPersona='".$value['idPersonaPresidente']."' data-toggle='modal' data-target='#modalDireccion' title='Editar dirección'><i class='fas fa-map-marked-alt'></i></button>";
					}
						$acciones .= "<button class='btn btn-success btn-sm editarPresidente' title='Editar Presidente' idPresidente='".$value['idPresidente']."' data-toggle='modal' data-target='#modalPresidente'><i class='fas fa-user-edit'></i></button></div>"; 
					if ($value['estadoPresidente'] == 1) {
						$estado = "<div class='btn btn-warning btn-sm text-white'>Activo</div>";
					}else{
						$estado = "<div class='btn btn-secondary btn-sm text-white'>Inactivo</div>";
						$acciones = "<h5><span class='badge badge-danger'>No disponible</span></h5>";;
					}
					$fecha = "<h5><span class='badge badge-info'>".$value['fechaRegistroPresidente']."</span></h5>";
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].', '.$value['nombrePersona'].'",
							"'.$value['dniPersona'].'",
							"'.$direccion.'",
							"'.$value['correoPresidente'].'",
							"'.$value['celularPresidente'].'",
							"'.$fecha.'",
							"'.$value['nombreLocalidad'].'",
							"'.$value['nombreComite'].'",
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

	$planes = new TablaPresidentes();
	$planes->mostrarTabla();