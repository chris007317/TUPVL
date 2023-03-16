<?php 
	require_once '../controlador/postulante.controlador.php';
	require_once '../modelo/postulante.modelo.php';
	session_start();
	Class TablaPresidentes{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
			$postulnates = '';
			if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarPostFecha') {
				$postulnates = ControladorPostulante::ctrMostrarPostulantes($_POST['fechaIncicio'].' 00:00:00', $_POST['fechaFin'].' 23:59:59', $idMunicipalidad, $_POST['estado']);	
			}else if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarPostEstado') {
				$postulnates = ControladorPostulante::ctrMostrarPostulantes('', '', $idMunicipalidad, $_POST['estado']);	
			}else{
				$postulnates = ControladorPostulante::ctrMostrarPostulantes('', '', $idMunicipalidad, 1);
			}
			if (count($postulnates) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($postulnates as $key => $value) {
					$btnDir = '';
					$acciones = "<div class='btn-group'>";
					if ($value['idDireccion'] == null) {
						$direccion = "No cosignada";
					}else{
						$direccion = $value['nombreDireccion'].' N° '.$value['numero'];
						$btnDir .= "<button class='btn btn-naranja btn-sm editarDireccion' title='Editar direccion' idDireccion='".$value['idDireccion']."' idPersona='".$value['idPersonaPostulante']."' data-toggle='modal' data-target='#modalDireccion'><i class='fas fa-map-marked-alt'></i></button>";
					}
					if ($value['estadoInscripcion'] == 2 || $value['estadoInscripcion'] == 0) {
					 	$acciones .="<button class='btn btn-secondary btn-sm verSocio' title='Ver Socio' idSocio='".$value['idSocioInscripcion']."' data-toggle='modal' data-target='#modalSocio' title='Ver socio'><i class='fas fa-user-friends'></i></button><a class='btn btn-danger btn-sm text-white verPdf' title='Ver PDF' href='generarficha/".$value['idPostulante']."/".$value['idInscripcion']."' target='_blank'><i class='fas fa-eye'></i></a></div>";
					 }else if($value['estadoInscripcion'] == 1){
						$acciones .= $btnDir."<button class='btn btn-secondary btn-sm verSocio' title='Ver Socio' idSocio='".$value['idSocioInscripcion']."' data-toggle='modal' data-target='#modalSocio' title='Ver socio'><i class='fas fa-user-friends'></i></button><button class='btn btn-jade btn-sm editarPostulante'  idInscripcion='".$value['idInscripcion']."' data-toggle='modal' data-target='#modalPostulante' title='Editar postulante'><i class='fas fa-user-tag'></i></button><a class='btn btn-danger btn-sm text-white verPdf' title='Ver PDF' href='generarficha/".$value['idPostulante']."/".$value['idInscripcion']."' target='_blank'><i class='fas fa-eye'></i></a><button class='btn btn-info btn-sm accionPostulante'idPostulante='".$value['idPostulante']."' idInscripcion='".$value['idInscripcion']."' tipoPost='".$value['idTipoInscripcion']."' data-toggle='modal' data-target='#modalAccionPostulante' title='Aceptaro o rechazar'><i class='fas fa-play'></i></button></div>";
				 	}
					$fecha = "<h6><span class='badge badge-info'>".$value['fechaNacimiento']."</span></h6>";
					$fechaReg = "<h6><span class='badge badge-info'>".$value['fechaRegistro']."</span></h6>";
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['fechaRegistro'].'",
							"'.$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].', '.$value['nombrePersona'].'",
							"'.$value['dniPersona'].'",
							"'.$direccion.'",
							"'.$fecha.'",
							"'.$value['sexoPostulante'].'",
							"'.$value['descripcionPostulante'].'",
							"'.strtoupper($value['nombreLocalidad'].' - '.$value['nombreComite']).'",
							"'.strtoupper($value['nombreTipoBeneficiario']).'",
							"'.strtoupper($value['nombreTipoSocio']).'",
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