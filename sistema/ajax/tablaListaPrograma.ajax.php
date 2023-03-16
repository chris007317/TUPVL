<?php 
	require_once '../controlador/almacen.controlador.php';
	require_once '../modelo/almacen.modelo.php';
	session_start();
	Class TablaAlamacen{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
			$nombreMeses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				//echo '<pre>'; print_r($_POST); echo '</pre>';
			if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarProducto') {
				$almacen = ControladorAlmacen::ctrMostrarListaProductos($idMunicipalidad, $_POST['year'], $_POST['nombreProducto']);	
			}else{
				$almacen = ControladorAlmacen::ctrMostrarListaProductos($idMunicipalidad, '', '');	
			}
			if (count($almacen) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$estado = '';
				$datosJson = '{
				"data":[';
				foreach ($almacen as $key => $value) {
					if ($value['estadoProgramar'] == 0) {
						$estado = "<div class='text-center'><h5><span class='badge badge-warning'>Por entregar</span></h5</div>";
					}else{
						$estado = "<div class='text-center'><h5><span class='badge badge-dark'>Entregado</span></h5</div>";
					}
					$cantidad = "<div class='text-center'><h5><span class='badge badge-dark'>".$value['cantidadEntrega']."</span></h5</div>";
					$entregados = "<div class='text-center'><h5><span class='badge badge-danger'>".$value['entregados']."</span></h5</div>";
					$mes = "<div class='text-center'><h5><span class='badge badge-info'>".$nombreMeses[$value['mesEntrega']-1]."</span></h5</div>";
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['codigoProducto'].'",
							"'.strtoupper($value['nombreProducto']).'",
							"'.$value['marcaProducto'].'",
							"'.$value['descripcionProducto'].'",
							"'.$cantidad.'",
							"'.$mes.'",
							"'.$entregados.'",
							"'.$estado.'"
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