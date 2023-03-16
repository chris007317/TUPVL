<?php 
	require_once '../controlador/almacen.controlador.php';
	require_once '../modelo/almacen.modelo.php';

	require_once '../controlador/municipalidad.controlador.php';
	require_once '../modelo/municipalidad.modelo.php';

	require_once '../controlador/beneficiario.controlador.php';
	require_once '../modelo/beneficiario.modelo.php';

	require_once '../controlador/comite.controlador.php';
	require_once '../modelo/comite.modelo.php';
	session_start();
	Class TablaAlamacen{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$idMunicipalidad =  $_SESSION['idMunicipalidadPvl'];
			$nombreMeses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$disponibles = ControladorAlmacen::VerProductos($idMunicipalidad);
			
			//$beneficiairiosActivos = ControladorBeneficiario::ctrMostrarBeneficiariosMesVal($idMunicipalidad, 1, $_POST['idMes'], $_POST['year']);

			$idMes = $_POST['idMes'];
			$yearEntrega = $_POST['year'];
			//$totalBeneficiarios = count($beneficiairiosActivos) - $contarMes['total'];
			$entregar = [];
			/*----------  arreglo de productos a entregar  -- --------*/
			foreach ($disponibles as $key6 => $value) {
				$lista = ControladorMunicipalidad::ctrMostrarPeriodosMes($idMunicipalidad, $idMes, $yearEntrega, $value['nombreProducto']);
				if (strtoupper($value['nombreProducto']) == 'LECHE') {
					$idNomProd= 2;
				}else if (strtoupper($value['nombreProducto']) == 'AVENA') {
					$idNomProd= 1;
				}
				$contarMes = ControladorMunicipalidad::ctrContarPorMes($idMunicipalidad, $idMes, $yearEntrega, $idNomProd);
				if (!empty($lista)) {
					$total = $lista['total'];
					$fila = array('nombreProducto' => $value['nombreProducto'],'racion' => $total / $contarMes['total'],'idNomProd' => $idNomProd);
					array_push($entregar, $fila);	
				}
			}
			
			if (count($entregar) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$comitesTotal = ControladorComite::ctrMostrarComites($idMunicipalidad);
				$contarBenefComite = 0;
				$cadLeche = [];
				$cadAvena = [];
				$prodEntregarLeche = 0;
				$prodEntregarAvena = 0;
				/*----------  ciclo para saber los beneficiarios activos de cada comites  ----------*/
					
				foreach ($entregar as $key0 => $valor) {
					$comites = ControladorMunicipalidad::ctrMostrarComites($idMunicipalidad, $idMes, $yearEntrega, $valor['idNomProd']);
					foreach ($comites as $key4 => $val) {
						$fila = array('idComite' =>$val['idComiteEntrega'], 'numBeneficiarios' => $val['numBenef'], 'nombreProducto' => $valor['nombreProducto'], 'total' => $val['numBenef'] * $valor['racion'], 'idNomProd' => $valor['idNomProd']);
						if ($valor['idNomProd'] == 1) {
							array_push($cadAvena, $fila);
						}else if($valor['idNomProd'] == 2){
							//echo '<pre>'; print_r($fila); echo '</pre>';
							array_push($cadLeche, $fila);			
						}
					}
					//$fila = array('idComite' => $valor['idComite'],'nombreComite'=>$valor['nombreComite'], 'nombreLocalidad' => $valor['nombreLocalidad'], 'numBenef' => $contarBenefComite);
					//	array_push($benefComite, $fila);	
					//	$contarBenefComite = 0;
				}

				$totalProd = 0 ;
				$datosJson = '{
				"data":[';
				$acciones = '';
				foreach ($comitesTotal as $key => $value) {
					foreach ($cadAvena as $key1 => $valor) {
						if ($valor['idComite'] == $value['idComite']) {
							$prodEntregarAvena = $valor['total'];
							$contarBenefComite = $valor['numBeneficiarios'];
							break;
						}
					}
					foreach ($cadLeche as $key2 => $valor) {
						if ($valor['idComite'] == $value['idComite']) {
							$prodEntregarLeche = $valor['total'];
							$contarBenefComite = $valor['numBeneficiarios'];
							break;
						}	
					}
					$comiteSalida = ControladorAlmacen::ctrContarSalidaComite($value['idComite'], $idMes, $yearEntrega);
					$btnLeche = 0; 
					$btnAvena = 0;
					if (!empty($comiteSalida)) {
						foreach ($comiteSalida as $key7 => $comite) {
								if (strtoupper($comite['nombreProducto']) == 'LECHE') {
									$btnLeche++;
								}else if (strtoupper($comite['nombreProducto']) == 'AVENA') {
									$btnAvena++;
								}
							}	
					}
					$totalProd = ($prodEntregarAvena + $prodEntregarLeche);
					if ($btnLeche > 0 && $btnAvena > 0) {
						$mesYear = $idMes.'-'.$yearEntrega;
						$acciones = "<div class='btn-group'><a class='btn btn-outline-secondary btn-sm' title='Ver pecosa' href='pecosa/".$value['idComite']."/".$mesYear."' target='_blank'><i class='far fa-file-alt'></i> Pecosa</a><a class='btn btn-outline-dark btn-sm' title='Ver padron' href='padron/".$value['idComite']."/".$mesYear."' target='_blank'><i class='far fa-file-alt'></i> Padron</a></div>";
					}else if ($btnAvena > 0 && $prodEntregarLeche > 0) {
						$acciones = "<div class=' btn-group'><button class='btn btn-info btn-sm'>Entregado</button><button class='btn btn-danger btn-sm leche'  data-toggle='modal' data-target='#entregarAlimento' idMes='".$idMes."' idComite='".$value['idComite']."' comite='".$value['nombreComite']."' beneficiarios='".$contarBenefComite."' leche='".$prodEntregarLeche."' year='".$yearEntrega."'><i class='fas fa-clipboard-check'></i> Leche</button></div>";
					}else if($btnLeche > 0 && $prodEntregarAvena > 0){
						$acciones = "<div class=' btn-group'><button class='btn btn-info btn-sm avena' data-toggle='modal' data-target='#entregarAlimento' idMes='".$idMes."' idComite='".$value['idComite']."' comite='".$value['nombreComite']."' beneficiarios='".$contarBenefComite."' avena='".$prodEntregarAvena."' year='".$yearEntrega."'><i class='fas fa-clipboard-check'></i> Avena</button><button class='btn btn-danger btn-sm'>Entregado</button></div>";
					}else if ($btnAvena > 0 && $prodEntregarLeche == 0) {
						$acciones = "<div class=' text-center'><button class='btn btn-info btn-sm'>Entregado</button></div>";
					}else if($btnLeche > 0 && $prodEntregarAvena == 0){
						$acciones = "<div class=' text-center'><button class='btn btn-danger btn-sm'>Entregado</button></div>";
					}else{
						if ($prodEntregarAvena > 0 && $prodEntregarLeche == 0) {
								$acciones = "<div class='text-center'><button class='btn btn-info btn-sm avena'  data-toggle='modal' data-target='#entregarAlimento' idMes='".$idMes."' idComite='".$value['idComite']."' comite='".$value['nombreComite']."' beneficiarios='".$contarBenefComite."' avena='".$prodEntregarAvena."' year='".$yearEntrega."'><i class='fas fa-clipboard-check'></i> Avena</button></div>";
						}else if ($prodEntregarLeche > 0 && $prodEntregarAvena == 0){
							$acciones = "<div class='text-center'><button class='btn btn-danger btn-sm leche'  data-toggle='modal' data-target='#entregarAlimento' idMes='".$idMes."' idComite='".$value['idComite']."' comite='".$value['nombreComite']."' beneficiarios='".$contarBenefComite."' leche='".$prodEntregarLeche."' year='".$yearEntrega."'><i class='fas fa-clipboard-check'></i> leche</button></div>";
						}else if ($totalProd > 0) {
							$acciones = "<div class='btn-group'><button class='btn btn-info btn-sm avena'  data-toggle='modal' data-target='#entregarAlimento' idMes='".$idMes."' idComite='".$value['idComite']."' comite='".$value['nombreComite']."' beneficiarios='".$contarBenefComite."' avena='".$prodEntregarAvena."' year='".$yearEntrega."'><i class='fas fa-clipboard-check'></i> Avena</button><button class='btn btn-danger btn-sm leche'  data-toggle='modal' data-target='#entregarAlimento' idMes='".$idMes."' idComite='".$value['idComite']."' comite='".$value['nombreComite']."' beneficiarios='".$contarBenefComite."' leche='".$prodEntregarLeche."' year='".$yearEntrega."'><i class='fas fa-clipboard-check'></i> Leche</button></div>";
						}
					}
					$benef = "<span class='badge badge-warning'>".$contarBenefComite."</span>";
					$cantavena = "<span class='badge badge-info'>".$prodEntregarAvena."</span>";
					$cantleche = "<span class='badge badge-danger'>".$prodEntregarLeche."</span>";
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombreLocalidad'].'",
							"'.strtoupper($value['nombreComite']).'",
							"'.$benef.'",
							"'.$cantavena.'",
							"'.$cantleche.'",
							"'.$totalProd.'",
							"'.$acciones.'"
					],';
					$prodEntregarLeche = 0;
					$prodEntregarAvena = 0;
					$contarBenefComite = 0;
					$totalProd = 0;
					$acciones = '';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				echo $datosJson;
			}
		}
	}

	$planes = new TablaAlamacen();
	$planes->mostrarTabla();