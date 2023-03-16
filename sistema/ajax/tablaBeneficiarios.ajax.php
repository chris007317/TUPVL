<?php 
	require_once '../controlador/beneficiario.controlador.php';
	require_once '../modelo/beneficiario.modelo.php';
	require_once '../helper/funciones.php';
	session_start();
	Class TablaPresidentes{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
			$beneficiarios = '';
			date_default_timezone_set('America/Lima');
			$fechaActual =  Date('Y-m-d');
				//echo '<pre>'; print_r($_POST); echo '</pre>';
			if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarFechaItem') {
				$beneficiarios = ControladorBeneficiario::ctrMostrarBeneficiarios($idMunicipalidad, $_POST['item'], $_POST['valor'], $_POST['fechaInicio'].' 00:00:00', $_POST['fechaFin'].' 23:59:59', $_POST['estado']);	
			}else if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarBenef') {
				$beneficiarios = ControladorBeneficiario::ctrMostrarBeneficiarios($idMunicipalidad, $_POST['item'], $_POST['valor'], '', '', $_POST['estado']);	
			}else if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarBenefFecha') {
				$beneficiarios = ControladorBeneficiario::ctrMostrarBeneficiarios($idMunicipalidad, '', '', $_POST['fechaInicio'].' 00:00:00', $_POST['fechaFin'].' 23:59:59',  $_POST['estado']);
			}else if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarBenefEstado') {
				$beneficiarios = ControladorBeneficiario::ctrMostrarBeneficiarios($idMunicipalidad, '', '', '', '',  $_POST['estado']);
			}else{
				$beneficiarios = ControladorBeneficiario::ctrMostrarBeneficiarios($idMunicipalidad, '', '', '', '',  1);
			}
			if (count($beneficiarios) == 0) { 
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($beneficiarios as $key => $value) {
					$btnDir = '';
					$vencido = '';
					$fechav = new DateTime($value['fechaVencimiento']);
					if ($value['fechaVencimiento'] != null) {
						$vencido = calcularVencimiento($fechaActual, $value['fechaVencimiento']);
						$fechaVen = "<h6><span class='badge badge-info'>".$vencido."</span></h6>";
					}else{
						$fechaVen = "<h6><span class='badge badge-secondary'>Indefinido</span></h6>";;
					}
					$acciones = "<div class='btn-group'>";
					if ($value['idDireccion'] == null) {
						$direccion = "No cosignada";
					}else{
						$direccion = $value['nombreDireccion'].' N° '.$value['numero'];
						$btnDir .= "<button class='btn btn-primary btn-sm editarDireccion' title='Editar direccion' idDireccion='".$value['idDireccion']."' idPersona='".$value['idPersonaPostulante']."' data-toggle='modal' data-target='#modalDireccion'><i class='fas fa-map-marked-alt'></i></button>";
					}
					//if ($value['idEstadoBenef'] == 3 || $fechav < $fechaActual) {
					if ($value['idEstadoBenef'] == 3) {
						$acciones .= "<button class='btn btn-success btn-sm verSocio' title='Ver Socio' idSocio='".$value['idSocioBenef']."' data-toggle='modal' data-target='#modalSocio' title='Ver socio'><i class='fas fa-user-friends'></i></button><button class='btn btn-secondary btn-sm verBeneficiario' title='Ver beneficiario' idBeneficiario='".$value['idInscripcionBenef']."' idEstadoBenef='".$value['idEstadoBenef']."' data-toggle='modal' data-target='#verBeneficiario'><i class='fas fa-eye'></i></button></div>";
					}else{
						if ($vencido == 'Vencido') {
							$acciones .= "<button class='btn btn-success btn-sm verSocio' title='Ver Socio' idSocio='".$value['idSocioBenef']."' data-toggle='modal' data-target='#modalSocio' title='Ver socio'><i class='fas fa-user-friends'></i></button><button class='btn btn-secondary btn-sm verBeneficiario' title='Ver beneficiario' idBeneficiario='".$value['idInscripcionBenef']."' idEstadoBenef='".$value['idEstadoBenef']."' data-toggle='modal' data-target='#verBeneficiario'><i class='fas fa-eye'></i></button><button class='btn btn-danger btn-sm btnVencido' title='Vencido' idBeneficiario='".$value['idInscripcionBenef']."'><i class='fas fa-user-times'></i></button></div>";
						}else{
							$acciones .= $btnDir."<button class='btn btn-success btn-sm verSocio' title='Ver Socio' idSocio='".$value['idSocioBenef']."' data-toggle='modal' data-target='#modalSocio' title='Ver socio'><i class='fas fa-user-friends'></i></button><button class='btn btn-naranja btn-sm cambiarSocio' title='Cambiar socio' idBeneficiario='".$value['idInscripcionBenef']."' data-toggle='modal' data-target='#cambiarSocio'><i class='fas fa-user-plus'></i></button><button class='btn btn-secondary btn-sm verBeneficiario' title='Ver beneficiario' idBeneficiario='".$value['idInscripcionBenef']."' idEstadoBenef='".$value['idEstadoBenef']."' data-toggle='modal' data-target='#verBeneficiario'><i class='fas fa-eye'></i></button><button class='btn btn-warning text-white btn-sm editarBeneficiario' title='Ver beneficiario' idBeneficiario='".$value['idInscripcionBenef']."' idEstadoBenef='".$value['idEstadoBenef']."' data-toggle='modal' data-target='#editarBeneficiario'><i class='fas fa-location-arrow'></i></button></div>";

						}
					}
				 	
					$fecha = "<h6><span class='badge badge-info'>".$value['fechaNacimiento']."</span></h6>";
				//	$fecha = "<h6><span class='badge badge-info'>".calcularEdad($value['fechaNacimiento'])."</span></h6>";
					//$fechaVen = "<h6><span class='badge badge-info'>".$value['fechaVencimiento']."</span></h6>";
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['fechaInscripcion'].'",
							"'.$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].', '.$value['nombrePersona'].'",
							"'.$value['dniPersona'].'",
							"'.$direccion.'",
							"'.$fecha.'",
							"'.$value['sexoPostulante'].'",
							"'.strtoupper($value['nombreLocalidad'].' - '.$value['nombreComite']).'",
							"'.strtoupper($value['nombreTipoBeneficiario']).'",
							"'.strtoupper($value['nombreTipoSocio']).'",
							"'.$fechaVen.'",
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