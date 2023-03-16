<?php 
	require_once '../controlador/municipalidad.controlador.php';
	require_once '../modelo/municipalidad.modelo.php';

	require_once '../controlador/beneficiario.controlador.php';
	require_once '../modelo/beneficiario.modelo.php';

	require_once '../controlador/almacen.controlador.php';
	require_once '../modelo/almacen.modelo.php';

	require_once '../controlador/comite.controlador.php';
	require_once '../modelo/comite.modelo.php';

	require_once '../helper/funciones.php';
	session_start();
	Class AjaxMunicipalidad{
		public function ajaxMostrarMunicipalidad($idMunicipalidad){
			$respuesta = ControladorMunicipalidad::ctrMostrarMunicipalidad($idMunicipalidad);
			echo json_encode($respuesta);

		}
		/*----------  tabla periodos municipalidad  ----------*/
		public function ajaxVeTablaPeriodo($idMunicipalidad){
			$respuesta = ControladorMunicipalidad::ctrTablaPeriodo($idMunicipalidad);
			$template = ''; 
			foreach ($respuesta as $key => $value) {
				if (date("Y") == $value['yearPeriodo']) {
					$estado = "<button class='btn btn-warning btn-sm text-white'>Activo</button>";
				}else{
					$estado = "<button class='btn btn-secondary btn-sm text-white'>Inactivo</button>";
				}
				$meses = 12 / $value['periodo'];
				$template .='<tr>
							<td>'.($key+1).'</td>
							<td>'.$value['periodo'].' meses</td> 
							<td>'.$meses.' al año</td>
							<td>'.$value['yearPeriodo'].'</td>
							<td>'.$estado.'</td>
						</tr>';
			} 
			echo $template;
		}
		public function ajaxVerPeriodos($idMunicipalidad, $nombreProducto){
			$respuesta = ControladorMunicipalidad::ctrMostrarPeriodos($idMunicipalidad, $nombreProducto);
			$checkPeriodo = mesesPeriodo($respuesta);
			echo json_encode($checkPeriodo);
		}

		public function ajaxTablaProducto($idMunicipalidad, $meses, $numBeneficiarios, $totalProductos, $year){
			$numMes = count($meses); 
			$racionMes = intdiv($totalProductos, $numBeneficiarios * $numMes); 
			$contarProdMes = 0;
			$datos = [];
			$nombreMeses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				foreach ($meses as $key => $mesValor) {
					/* calculamos los beneficiarios que deben recibir la racion mensual */
					$totalBenef = ControladorBeneficiario::ctrTotalBeneficiariosActivosMes($idMunicipalidad, $mesValor['mesEntrega'], $year, 1);
					$totalBeneficiarios = ControladorBeneficiario::ctrContarPorMes($idMunicipalidad, $mesValor['mesEntrega'], $year, 1);
					$totalBeneficiarios['total'] = $totalBenef['total'] - $totalBeneficiarios['total'];	
					
					$contarProdMes = $totalBeneficiarios['total'];
					$id = $mesValor['mesEntrega'];
					/* calculamos el numero de raciones por beneficiario activo */
					$racionMes = intdiv($totalProductos, $contarProdMes * $numMes); 
					$cantidadMes = $contarProdMes*$racionMes;
					$totalProductos = $totalProductos - $cantidadMes;
					/* agregamos los datos al arreglo para luego mostrarlos */
					$fila = array('id' => $id,'mesEntrega' => $nombreMeses[$id-1], 'beneficiarios' => $contarProdMes, 'racion'=> $racionMes, 'sobrante' => $totalProductos, 'cantidad' =>$cantidadMes);
					array_push($datos, $fila);
					$numMes = $numMes-1;
					$contarProdMes = 0;
				}
				/*=============================================
				=            bloque que va sumando uno por uno los beneficiarios           =
				$beneficiairios = ControladorBeneficiario::ctrMostrarBeneficiariosMes($idMunicipalidad, 1);
					foreach ($meses as $key => $mesValor) {

						foreach ($beneficiairios as $key => $value) {
							if ($value['mesRegistro'] <= $mesValor['mesEntrega'] && $value['yearRegistro'] <= $year) {
								if ($value['yearVencimiento'] == null  || ($value['mesVencimiento'] >= $mesValor['mesEntrega'] && $value['yearVencimiento'] = $year) || $value['yearVencimiento'] > $year) {
									$contarProdMes++;
								}
							}
									
						}
						$id = $mesValor['mesEntrega'];
						$racionMes = intdiv($totalProductos, $contarProdMes * $numMes); 

						$cantidadMes = $contarProdMes*$racionMes;
						$totalProductos = $totalProductos - $cantidadMes;
						$fila = array('id' => $id,'mesEntrega' => $nombreMeses[$id-1], 'beneficiarios' => $contarProdMes, 'racion'=> $racionMes, 'sobrante' => $totalProductos, 'cantidad' =>$cantidadMes);
						array_push($datos, $fila);
						$numMes = $numMes-1;
						$contarProdMes = 0;
					}
				=============================================*/				
				
				/*=====  End of Section comment block  ======*/
				
			return $datos;
		}

		public function ajaxTablaTipoProductos($idMunicipalidad, $nombreProducto, $tabla1, $year){
			$almacen = ControladorAlmacen::ctrMostrarProductoALmacen($idMunicipalidad, 'nombreProducto', $nombreProducto);
			$datos= [];
			foreach ($tabla1 as $key => $mesesDatos) {
				$cantidadPorMes = $mesesDatos['cantidad'];
				foreach ($almacen as $key => $value) {
					$stock = $value['stock'];
					if ($stock > 0 && $stock <= $cantidadPorMes) {
						$almacen[$key]['stock'] = 0;
						$fila = array('id' => $mesesDatos['id'],'mesEntrega' => $mesesDatos['mesEntrega'], 'idProducto' => $value['idProducto'], 'nombreProducto' => $value['nombreProducto'], 'marcaProducto'=> $value['marcaProducto'], 'cantidad' =>$stock, 'year' => $year, 'estado'=>0);
						$cantidadPorMes = $cantidadPorMes - $stock;
						array_push($datos, $fila);
					}else if($stock > $cantidadPorMes){
						$almacen[$key]['stock'] = $almacen[$key]['stock'] - $cantidadPorMes;
						$fila = array('id' => $mesesDatos['id'],'mesEntrega' => $mesesDatos['mesEntrega'], 'idProducto' => $value['idProducto'], 'nombreProducto' => $value['nombreProducto'], 'marcaProducto'=> $value['marcaProducto'], 'cantidad' =>$cantidadPorMes, 'year' => $year, 'estado'=>0);
						array_push($datos, $fila);
						break;
					}					
				}
			}
			return $datos;
		}

		public function ajaxGuardarPrograma($tabla, $year){
			$contar = 0;
			$filas = count($tabla);
			foreach ($tabla as $key => $value) {
				$guardarPrograma = ControladorMunicipalidad::ctrGuardarPrograma($value['idProducto'], $value['id'], $value['cantidad'], $year);
				if ($guardarPrograma > 0) {
					$contar++;
				}
			}
			if ($contar == $filas) {
				return 'ok';
			}else{
				return 'novalido';
			}
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarDatosMuni') {
		$propuestas = new AjaxMunicipalidad();
		$idMunicipalidad = $_POST['idMunicipalidad'];
		$propuestas->ajaxMostrarMunicipalidad($idMunicipalidad);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarDatosPeriodo') {
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$propuestas = new AjaxMunicipalidad();
		$propuestas->ajaxVeTablaPeriodo($idMunicipalidad);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'verPeriodos') {
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$propuestas = new AjaxMunicipalidad();
		$propuestas->ajaxVerPeriodos($idMunicipalidad, $_POST['nombreProducto']);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'programarEntrega') {
		$meses = [];
		for ($i = 1; $i <= 12; $i++) { 
			if(isset($_POST['checkMesPeriodo'.$i])){
				$mes = array('mesEntrega' => $_POST['checkMesPeriodo'.$i]);
				array_push($meses, $mes);
			}
		}
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$numBeneficiarios = $_POST['totalBeneficiarios'];
		$totalProductos = $_POST['totalProductos'];
		$year = intval($_POST['yearPerido']);
		$propuestas = new AjaxMunicipalidad();
		$tabla1 = $propuestas->ajaxTablaProducto($idMunicipalidad, $meses, $numBeneficiarios, $totalProductos, $year);
		$template1 = ''; 
		foreach ($tabla1 as $key => $value) {
			$template1 .='<tr>
						<td>'.($value['id']).'</td>
						<td>'.$value['mesEntrega'].'</td>
						<td>'.$value['beneficiarios'].'</td>
						<td>'.$value['racion'].'</td>
						<td>'.$value['cantidad'].'</td>
						<td>'.$value['sobrante'].'</td>
					</tr>';
		}
		$nombreProducto = $_POST['cmbPeriodoProducto'];
		$tabla2 = $propuestas->ajaxTablaTipoProductos($idMunicipalidad, $nombreProducto, $tabla1, $year);
		$template2 = ''; 
		$estadoPrograma = '';
		foreach ($tabla2 as $key => $value) {
			if ($value['estado'] == 0) {
				$estadoPrograma = '<span class="badge badge-warning">Por entregar</span>';
			}
			$template2 .='<tr>
						<td>'.($value['id']).'</td>
						<td>'.$value['nombreProducto'].'</td>
						<td>'.$value['marcaProducto'].'</td>
						<td>'.$value['mesEntrega'].'</td>
						<td>'.$value['cantidad'].'</td>
						<td>'.$value['year'].'</td>
						<td>'.$estadoPrograma.'</td>
					</tr>';
		}		
		$respuesta = array('tabla1' => $template1, 'tabla2' => $template2);
		echo json_encode($respuesta);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'guardarPrograma') {
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$numBeneficiarios = $_POST['totalBeneficiarios'];
		$totalProductos = $_POST['totalProductos'];
		$nombreProducto = $_POST['nombreProducto'];
		$idNomProd = 0;
		if (strtoupper($nombreProducto) == 'AVENA') {
			$idNomProd = 1;
		}else if (strtoupper($nombreProducto) == 'LECHE') {
			$idNomProd = 2;
		}
		$year = $_POST['yearPeriodo'];
		$arreglomeses = explode(",", $_POST['meses']);
		$arregloMeses = sort($arreglomeses);

		$meses = [];
		for ($i = 0; $i < 12; $i++) { 
			if(isset($arreglomeses[$i])){
				$mes = array('mesEntrega' => $arreglomeses[$i]);
				array_push($meses, $mes);
			}
		}
		$propuestas = new AjaxMunicipalidad();
		$tabla1 = $propuestas->ajaxTablaProducto($idMunicipalidad, $meses, $numBeneficiarios, $totalProductos, $year);
		$comites = ControladorComite::ctrMostrarComites($idMunicipalidad);
		$tabla2 = $propuestas->ajaxTablaTipoProductos($idMunicipalidad, $nombreProducto, $tabla1, $year);
		$guardar = $propuestas->ajaxGuardarPrograma($tabla2, $year);
		$contarBenefComite = 0;
		$totComite = count($comites);
		$totTbla = count($tabla1);
		$contar = 0;
		if ($guardar == 'ok') {
			foreach ($tabla1 as $key => $value1) {
				$beneficiairiosActivos = ControladorBeneficiario::ctrMostrarBeneficiariosMesVal($idMunicipalidad, 1, $value1['id'], $year);
				/*----------  ciclo para saber los beneficiarios activos de cada comites  ----------*/
				foreach ($comites as $key => $valor) {
					$arrBeneficiarios = [];
					foreach ($beneficiairiosActivos as $key => $value) {
						if ($valor['idComite'] == $value['idComiteBenef'] && $valor['estadoComite'] == 1) {
							/* codigo que seleccionaba a los beneficiarios por comites*/
							/* 
								if ($value['yearVencimiento'] == null  || ($value['mesVencimiento'] >= $value1['id'] && $value['yearVencimiento'] == $year) || $value['yearVencimiento'] > $year) {
										$contarBenefComite++;
										$fil = array('idBeneficiario' => $value['idInscripcionBenef']);
										array_push($arrBeneficiarios, $fil);
								}
							 */
							$contarBenefComite++;
							$fil = array('idBeneficiario' => $value['idInscripcionBenef']);
							array_push($arrBeneficiarios, $fil);
						}
					}
					$benefId = json_encode($arrBeneficiarios);
					$guardarPrograma = ControladorMunicipalidad::ctrGuardarEntrega($valor['idComite'], $contarBenefComite, $value1['id'], $year, $idNomProd, $benefId);

					
					if ($guardarPrograma > 0) {
						$contar++;
					}
					$contarBenefComite = 0;
				}
			}
			if ($contar == ($totComite * $totTbla)) {
				echo "ok";
			}else{
				echo "novalido";
			}
		}else{
			echo "novalido";
		}

	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'veDisponibilidad') {
		date_default_timezone_set('America/Lima');
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$year = date('Y');
		$mes = date('n');
		$respuesta = ControladorMunicipalidad::ctrVerDisponibilidad($idMunicipalidad, $year, $mes, 0);
		if ($respuesta['total'] > 0) {
			echo "no";
		}else{
			echo "si";
		}
	}

?>