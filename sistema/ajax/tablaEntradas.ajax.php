<?php 
	require_once '../controlador/entrada.controlador.php';
	require_once '../modelo/entrada.modelo.php';
	session_start();
	Class TablaEntradas{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
			$Entradas = ControladorEntrada::ctrMostrarEntradas($idMunicipalidad);
			if (count($Entradas) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($Entradas as $key => $value) {
					$cantidad = "<div class='text-center'><h5><span class='badge badge-dark'>".$value['cantidad']."</span></h5</div>";
					$fecha = "<div class='text-center'><h5><span class='badge badge-info'>".$value['fechaRecepcion']."</span></h5></div>";
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombreProducto'].' - '.$value['marcaProducto'].'",
							"'.$value['nombreProveedor'].'",
							"'.$value['rucProveedor'].'",
							"'.$value['observacion'].'",
							"'.$fecha.'",
							"'.$cantidad.'",
							"'.$value['nombrePersona'].'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				echo $datosJson;
			}
		}
	}

	$planes = new TablaEntradas();
	$planes->mostrarTabla();