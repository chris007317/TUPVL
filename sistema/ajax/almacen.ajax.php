<?php 
	require_once '../controlador/almacen.controlador.php';
	require_once '../modelo/almacen.modelo.php'; 

	require_once '../controlador/municipalidad.controlador.php';
	require_once '../modelo/municipalidad.modelo.php';

	require_once '../controlador/beneficiario.controlador.php';
	require_once '../modelo/beneficiario.modelo.php';
	session_start(); 
	Class AjaxAlmacen{
		public function ajaxVercantidadProducto($nombreProducto, $idMunicipalidad, $year, $estado){
			$respuesta = ControladorAlmacen::ctrContarProductos($nombreProducto, $idMunicipalidad);
			$productoRepartir = ControladorMunicipalidad::ctrMostrarPeriodos($idMunicipalidad, $nombreProducto);
			$total = 0;
			$mes = 0;
			$contar = 0;
			if (!empty($productoRepartir)) {
				foreach ($productoRepartir as $key => $value) {
					$total = $value['total'] - $value['totalEntregado'] + $total;
				}
				foreach ($productoRepartir as $key => $value) {	
					$contar++;
					$mes = intval($value['mesEntrega']);
					if ($contar != $mes) {
						$mes = $contar;
						break;
					}
				}	 
			}

			if ($mes == 0) {
				$mes = $mes + 1; 
			}
			//$totalBenef = ControladorBeneficiario::ctrTotalBeneficiarios($idMunicipalidad, 1);
			/* contar los beneficairios activos que se encusntrar en el rango de mes y año */
			$totalBenef = ControladorBeneficiario::ctrTotalBeneficiariosActivosMes($idMunicipalidad, $mes, $year, $estado);
			/* contar los beneficiatios que ya vencieron la suscripcion aunque esten activos*/
			$totalBeneficiarios = ControladorBeneficiario::ctrContarPorMes($idMunicipalidad, $mes, $year, $estado);
			/* restar el total de beneficiarios inscritos menos el total de beneficiarios que ya vencieron */
			$totalBeneficiarios['total'] = $totalBenef['total'] - $totalBeneficiarios['total'];
			/* si el total es cero por el motivo de que no se haya registrado beneficiarios hara el calculo anterior hasta encontrar un mes donde haya beneficiarios*/
			if ($totalBeneficiarios['total'] == 0) {
				while($totalBeneficiarios['total'] == 0){
					$mes++;
					if ($mes > 12) {
						break;
					}
					$totalBenef = ControladorBeneficiario::ctrTotalBeneficiariosActivosMes($idMunicipalidad, $mes, $year, $estado);
					
					$totalBeneficiarios = ControladorBeneficiario::ctrContarPorMes($idMunicipalidad, $mes, $year, $estado);
					
					$totalBeneficiarios['total'] = $totalBenef['total'] - $totalBeneficiarios['total'];
				}
				
			}
			if (!empty($productoRepartir)) {
				foreach ($productoRepartir as $key => $val) {
					if ($mes == intval($val['mesEntrega'])) {
						$mes ++;
					}else{
						break;
					}
				}
			}
			$totalBenef = ControladorBeneficiario::ctrTotalBeneficiariosActivosMes($idMunicipalidad, $mes, $year, $estado);
			$totalBeneficiarios = ControladorBeneficiario::ctrContarPorMes($idMunicipalidad, $mes, $year, $estado);
			$totalBeneficiarios['total'] = $totalBenef['total'] - $totalBeneficiarios['total'];		
			$array = [
			    "mes" => $mes,
			];

			$respuesta['disponible'] = intval($respuesta['disponible']) - intval($total);
			
			$datos = array_merge($respuesta, $totalBeneficiarios);
			$datos1 = array_merge($datos, $array);
			echo json_encode($datos1);

		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'verCantidadProducto') {
		$nombreProducto = $_POST['nombreProducto'];
		$yearPerido = $_POST['yearPerido'];
		$estado = $_POST['estado'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$propuestas = new AjaxAlmacen();
		$propuestas->ajaxVercantidadProducto($nombreProducto, $idMunicipalidad, $yearPerido, $estado);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'verTotalBenef') {
		$year = $_POST['yearPerido'];
		$estado = $_POST['estado'];
		$mes = $_POST['mes'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$totalBenef = ControladorBeneficiario::ctrTotalBeneficiariosActivosMes($idMunicipalidad, $mes, $year, $estado);
		$totalBeneficiarios = ControladorBeneficiario::ctrContarPorMes($idMunicipalidad, $mes, $year, $estado);
		$totalBeneficiarios['total'] = $totalBenef['total'] - $totalBeneficiarios['total'];
		echo json_encode($totalBeneficiarios);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'verProductos') {
		$nombreProducto = $_POST['nombreProducto'];
		$yearPerido = $_POST['yearPerido'];
		$mes = $_POST['mes'];
		$cantidadEntregar = $_POST['cantidad'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$respuesta = ControladorMunicipalidad::ctrMostrarProductosDisponibles($idMunicipalidad, $mes, $yearPerido, $nombreProducto);
		$checkList = '';
		$cant = '';
		$totalProd = 0;
		$productoDisponible = 0;
		foreach ($respuesta as $key => $value) {
			$productoDisponible = $value['cantidadEntrega'] - $value['entregados'];
			if ($cantidadEntregar > $productoDisponible) {
				$checkList .="<div class='custom-control custom-checkbox'><input class='custom-control-input' type='checkbox' name='checkProducto".($key+1)."' checked='true'  value='".$value['idProductoEntrega']."' readonly><label class='custom-control-label'>".$value['nombreProducto']." - ".$value['marcaProducto']."</label><input type='hidden' name='hiddenProducto".($key+1)."' value='".$productoDisponible."' required></div>";
				$cant .= "<div><span class='badge badge-dark'>".$productoDisponible."</span></div>";	
				$cantidadEntregar = $cantidadEntregar - $productoDisponible;
				$totalProd = $totalProd + 1;
			}else{
				$checkList .="<div class='custom-control custom-checkbox'><input class='custom-control-input' type='checkbox' name='checkProducto".($key+1)."' checked='true' value='".$value['idProductoEntrega']."' readonly><label class='custom-control-label'>".$value['nombreProducto']." - ".$value['marcaProducto']."</label><input type='hidden' name='hiddenProducto".($key+1)."' value='".$cantidadEntregar."' required></div>";
				$cant .= "<div><span class='badge badge-dark'>".$cantidadEntregar."</span></div>";
				$totalProd = $totalProd + 1;
				break;
			}
		}

		$template = "<div class='w-60'><strong>Alimentos</strong><div>".$checkList."</div></div><div class='w-40'><input type='hidden' name='totalProd' value='".$totalProd."' required><strong>Cantidad por alimento</strong>".$cant."</div>";
		echo $template;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarEntrega') {
		$fechaEntrega =  date("Y-m-d H:i:s", strtotime($_POST["dateFechaAlimento"])) ;
		$totalEntregar = $_POST['cantidadEntrega'];
		$observacion = '';
		$idComite = $_POST['idComite'];
		$idMes = $_POST['idMes'];
		$yearEntrega = $_POST['yearEntrega'];
		$idUsuario = $_SESSION['idUsuarioPvl'];
		$totalProd = $_POST['totalProd'];
		$cont = 0;
		$response = '';
		$fechaSalida = $yearEntrega.'-'.$idMes.'-01';
		for ($i = 1; $i <= $totalProd; $i++) { 
      		if(isset($_POST['checkProducto'.$i]) && isset($_POST['hiddenProducto'.$i])){
	            $idProducto = $_POST['checkProducto'.$i];  
	            $cantidadProducto = $_POST['hiddenProducto'.$i];  
	            $registrarEntrega = ControladorAlmacen::ctrRegistrarEntrega($fechaEntrega, $cantidadProducto, $observacion, $idProducto, $idComite, $idUsuario, $fechaSalida);
	            if ($registrarEntrega > 0) {
	            	$editarLista = ControladorAlmacen::ctrEditarListaProductos($idProducto, $idMes, $yearEntrega, $cantidadProducto);
	            	$editarAlmacen = ControladorAlmacen::ctrEditarStockAlmacen($idProducto, $cantidadProducto);
	            	if ($editarLista > 0 && $editarAlmacen > 0) {
	            		$cont = $cont + 1;
	            	}else{
	            		echo 'error';
	            		exit();
	            	}
	            }else{
	            	echo 'novalido';
	            	exit();
	            }
	        }
		}
		if ($cont == $totalProd) {
			echo 'ok';
		}else{
			echo 'novalido';
		}
		
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarSalida') {
		$respuesta = ControladorAlmacen::ctrMostrarSalida($_POST['idSalida']);
		echo json_encode($respuesta);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarSalida') {
		$respuesta = ControladorAlmacen::ctrEditarSalida($_POST['idSalida'], $_POST['txtObservacionSalida']);
		echo $respuesta;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarDatos') {
		$mes = array('ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SET', 'OCT', 'NOV', 'DIC');
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$leche = ControladorAlmacen::ctrContarSalidas($idMunicipalidad, 'Leche');		
		$avena = ControladorAlmacen::ctrContarSalidas($idMunicipalidad, 'Avena');
		$mes1 = [];
		$mes2 = [];
		foreach ($leche as $key => $value) {
			$fecha = $value['fechaSalida'];
			array_push($mes1, $fecha);		
		}
		foreach ($avena as $key => $value1) {
			$fecha = $value1['fechaSalida'];
			array_push($mes2, $fecha);		
		}
		$cantidadLeche = 0;
		$cantidadAvena = 0;
		$datos = [];
		$mese = array_unique(array_merge($mes1, $mes2));
		$mesCount = count($mese);
		if ($mesCount > 12) {
			$mesCount = 12;
		}
		$ver = 0;
		$ver1 = 0;
		for ($i = 0; $i < $mesCount; $i++) {
			foreach ($leche as $key => $value) {
				if ($mese[$i] == $value['fechaSalida']) {
					$cantidadLeche = $value['cantidad'];
					$ver++;
					break;
				}
			}
			foreach ($avena as $key => $value) {
				if ($mese[$i] == $value['fechaSalida']) {
					$cantidadAvena = $value['cantidad'];
					
					$ver1++;
					break;
				}
			}
			if ($ver == 0) {
				$cantidadLeche = 0;
			}else{
				$ver = 0;
			}
			if ($ver1 == 0) {
				$cantidadAvena = 0;
			}else{
				$ver1 = 0;
			}
			$fech = strtotime($mese[$i]);
			$m = intval(date('m', $fech));
			$y = date('Y', $fech);
			$fila = array('meses' => ($mes[$m-1].'-'.$y), 'leche' => intval($cantidadLeche), 'avena' => intval($cantidadAvena));
			array_push($datos, $fila);
		}
		echo json_encode($datos);
	}
?>