<?php 
	if (empty($_SESSION['validarUsuarioPvl'])) {
		header('location: ../');
	}
	require 'reporte/vendor/autoload.php';
		use Dompdf\Dompdf;
		use Dompdf\Options;
	if (empty($_GET['post']) || empty($_GET['ins'])) {
		header('location: ../../error');
	}else{
		$porciones = explode("-", $_GET['ins']);
		$mes = $porciones[0];
		$idComite = $_GET['post'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		if ($mes > 0 && $mes <= 12 && is_numeric($porciones[1]) && strlen($porciones[1]) == 4 && is_numeric($idComite)) {
			$cont1 = 0;
			$cont2 = 0;
			$pecosas = ControladorAlmacen::ctrGenerarPecosa($idMunicipalidad, $idComite, $mes, $porciones[1]);
			$dia = $pecosas[0]['dia'];
			$m = $pecosas[0]['mes'];
			$y = $pecosas[0]['y'];
			$totalProductos = 0;
			$productos = '';
			$padron = ControladorMunicipalidad::ctrMostrarPadron($idMunicipalidad, $idComite, $mes, $porciones[1]);
			$responsable = ControladorMunicipalidad::ctrMostrarrResponsbleMunicipalidad($idMunicipalidad);
			$cantLeche = 0;
			$cantAvena = 0;
			if ($responsable['imagenMunicipalidad']=='img/municipalidades/municpalidad.png') {
				$rutaImg = '';
			}else{
				$rutaImg = '<img class="img-muni" src="'.$rutaSistema.'vistas/'.$responsable['imagenMunicipalidad'].'">';
			}
			foreach ($padron as $key => $value) {
				$arrBenef = json_decode($value['arrBeneficiarios']);
				if ($value['idNomProd'] == 1) {
					$cont1 = count($arrBenef);
				}else if ($value['idNomProd'] == 2) {
					$cont2 = count($arrBenef);
				}
			}
			foreach ($pecosas as $key => $value) {
				$productos .= $value['nombreProducto'].' '.$value['marcaProducto'].', ';
				$totalProductos = $value['cantidad'] + $totalProductos;
				if ($value['nombreProducto'] == 'LECHE') {
					$cantLeche = $value['cantidad'] + $cantLeche;
				}else if($value['nombreProducto'] == 'AVENA'){
					$cantAvena = $value['cantidad'] + $cantAvena;
				}
			}
			
			$comite = ControladorComite::ctrMostrarComite($idComite);
			if ($cont1 == $cont2) {
				$beneficiarios = ControladorBeneficiario::ctrBenefPadron($idComite, $mes, $porciones[1]);
				$padronBenef = [];
				foreach ($beneficiarios as $key => $value) {
					foreach ($arrBenef as $key => $val) {
						if ($value['idInscripcionBenef'] == $val->idBeneficiario) {
							$fila = array('beneficiario'=>$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].' '.$value['nombrePersona'], 'dni'=>$value['dniPersona']);
							array_push($padronBenef, $fila);
						}
					}

				}
				ob_start();
			    include(dirname('__FILE__').'/padronPdf.php');
			    $html = ob_get_clean();
				// instantiate and use the dompdf class
				$options = new Options();
				$options->set('isRemoteEnabled', TRUE);
				$dompdf = new Dompdf($options);

				$dompdf->loadHtml($html);
				// (Optional) Setup the paper size and orientation
				$dompdf->setPaper('A4', 'portrait');
				// Render the HTML as PDF
				$dompdf->render();
				$canvas = $dompdf->get_canvas();
				$w = $canvas->get_width();
				$h = $canvas->get_height();
				$font = $dompdf->getFontMetrics()->get_font("arial", "bold");
				$canvas->page_text($w-570,$h-35, "RESPONSABLE DEL REPARTO: ................................................................................................... FIRMA Y SELLO: ...............................................", $font, 10, array(0,0,0));
				// Output the generated PDF to Browser
				$dompdf->stream('PADRON_'.$comite['nombreComite'].'.pdf',array('Attachment'=>0));
				exit;

			}else{
				header('location: ../../error');
				exit();
			}
		}else{
			header('location: ../../error');
			exit();
		}
	}
?> 