<?php 
	require_once '../controlador/socio.controlador.php';
	require_once '../modelo/socio.modelo.php';
	session_start();
	Class TablaSocios{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
			$socios = '';
			$socios = ControladorSocio::ctrMostrarSocios($idMunicipalidad);	
			if (count($socios) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($socios as $key => $value) {
					$acciones = "<div class='text-center'><button class='btn btn-primary btn-sm btnElegirSocio' title='Elegir socio' idSocio='".$value['idSocio']."'><i class='fas fa-step-forward'></i></button></div>"; 
					$direccion = $value['nombreDireccion'].' N° '.$value['numero'];
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].', '.$value['nombrePersona'].'",
							"'.$value['dniPersona'].'",
							"'.$direccion.'",
							"'.$value['descripcion'].'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				echo $datosJson;
			}
		}
	}

	$planes = new TablaSocios();
	$planes->mostrarTabla();