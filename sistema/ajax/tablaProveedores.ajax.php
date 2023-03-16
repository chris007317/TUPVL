<?php 
	require_once '../controlador/proveedor.controlador.php';
	require_once '../modelo/proveedor.modelo.php';
	session_start();
	Class TablaProveedores{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
			$proveedores = ControladorProveedor::ctrMostrarProveedores($idMunicipalidad);
			if (count($proveedores) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($proveedores as $key => $value) {
					if ($value['estadoProveedor'] == 1) {
						$estado = "<div class='text-center'><button class='btn btn-warning btn-sm text-white btnActivarProveedores' estadoProveedor='0' idProveedor='".$value['idProveedor']."'>Activo</button></div>";
					}else{
						$estado = "<div class='text-center'><button class='btn btn-secondary btn-sm text-white btnActivarProveedores' estadoProveedor='1' idProveedor='".$value['idProveedor']."'>Inactivo</button></div>";
					}
					$acciones = "<div class='text-center'><button class='btn btn-success btn-sm editarProveedor'  data-toggle='modal' data-target='#editarProveedor' idProveedor='".$value['idProveedor']."'><i class='fas fa-pencil-alt'></i></button></div>";
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombreProveedor'].'",
							"'.$value['rucProveedor'].'",
							"'.$value['direccionProveedor'].'",
							"'.$value['representanteProveedor'].'",
							"'.$value['telefonoProveedor'].'",
							"'.$value['correoProveedor'].'",
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

	$planes = new TablaProveedores();
	$planes->mostrarTabla();