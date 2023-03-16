<?php 
	require_once '../controlador/almacen.controlador.php';
	require_once '../modelo/almacen.modelo.php';
	session_start();
	Class TablaEntregados{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
			if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarPorMes') {
				$entregados = ControladorAlmacen:: ctrMostrarSalidas($_POST['year'], $_POST['idMes'], $idMunicipalidad);	
			}else{
				$entregados = ControladorAlmacen:: ctrMostrarSalidas('', '', $idMunicipalidad);	
			}
			if (count($entregados) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($entregados as $key => $value) {
						$acciones = "<button class='btn btn-warning btn-sm editarSalida' title='Editar salida' data-toggle='modal' data-target='#editarSalida' idSalida='".$value['idSalidaProducto']."'><i class='fas fa-pencil-alt'></i></button></div>"; 
						$fecha = "<span class='badge badge-info'>".$value['fechaEntrega']."</span>";
						$cantidad = "<span class='badge badge-dark'>".$value['cantidad']."</span>";
						$observacion = $value['observacion'];
						if (empty($observacion)) {
							$observacion = 'Ninguna';
						}
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombreComite'].'",
							"'.$value['nombreProducto']." - ".$value['marcaProducto'].'",
							"'.$fecha.'",
							"'.$cantidad.'",
							"'.$observacion.'",
							"'.$value['nombrePersona']." ".$value['apellidoPaternoPersona']." ".$value['apellidoMaternoPersona'].'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				echo $datosJson;
			}
		}
	}

	$planes = new TablaEntregados();
	$planes->mostrarTabla();