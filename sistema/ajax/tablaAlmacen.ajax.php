<?php 
	require_once '../controlador/almacen.controlador.php';
	require_once '../modelo/almacen.modelo.php';
	session_start();
	Class TablaAlamacen{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
			$almacen = ControladorAlmacen::ctrMostrarAlmacen($idMunicipalidad);
			if (count($almacen) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($almacen as $key => $value) {
					$cantidad = "<div class='text-center'><h5><span class='badge badge-dark'>".number_format($value['stock'])."</span></h5</div>";
					$precio = "<div class='text-center'><h5><span class='badge badge-danger'>./S ".number_format( $value['precioTotal'], 2, ".", " ")."</span></h5</div>";
					$peso = "<div class='text-center'><h5><span class='badge badge-info'>".number_format($value['pesoTotal'], 2, ".", " ")." Kg</span></h5</div>";
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['codigoProducto'].'",
							"'.$value['nombreProducto'].'",
							"'.$value['marcaProducto'].'",
							"'.$value['descripcionProducto'].'",
							"'.$cantidad.'",
							"'.$precio.'",
							"'.$peso.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				echo $datosJson;
			}
		}
	}

	$planes = new TablaAlamacen();
	$planes->mostrarTabla();