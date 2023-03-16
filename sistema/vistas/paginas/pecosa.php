<?php 
	require_once 'helper/numLetras.php';
	if (empty($_SESSION['validarUsuarioPvl'])) {
		header('location: ../');
	}
	require 'reporte/vendor/autoload.php';
		use Dompdf\Dompdf;
		use Dompdf\Options;
	if (empty($_GET['post']) || empty($_GET['ins'])) {
		echo "No es posible generar la factura.";
	}else{
		
		$porciones = explode("-", $_GET['ins']);
		$mes = $porciones[0];
		$idComite = $_GET['post'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		if ($mes > 0 && $mes <= 12 && is_numeric($porciones[1]) && strlen($porciones[1]) == 4 && is_numeric($idComite)) {
			$pecosas = ControladorAlmacen::ctrGenerarPecosa($idMunicipalidad, $idComite, $mes, $porciones[1]);
			$responsable = ControladorMunicipalidad::ctrMostrarrResponsbleMunicipalidad($idMunicipalidad);
			$rutaImg = '';
			$total = 0;
			$cont = 0;
			$dia = $pecosas[0]['dia'];
			$mes = $pecosas[0]['mes'];
			$y = $pecosas[0]['y'];
			if ($responsable['imagenMunicipalidad']=='img/municipalidades/municpalidad.png') {
				$rutaImg = '';
			}else{
				$rutaImg = '<img class="img-muni" src="'.$rutaSistema.'vistas/'.$responsable['imagenMunicipalidad'].'">';
			}
			$fecha = date('Y-m-d');
			if (!empty($pecosas)) {
				$comite = ControladorComite::ctrMostrarComite($idComite);
				$presidente = ControladorPresidente::ctrMostrarPresidente('idComitePresidente', $idComite);
				ob_start();
			    include(dirname('__FILE__').'/pecosaPdf.php');
			    $html = ob_get_clean();
				// instantiate and use the dompdf class
				$options = new Options();
				$options->set('isRemoteEnabled', TRUE);
				$dompdf = new Dompdf($options);

				$dompdf->loadHtml($html);
				// (Optional) Setup the paper size and orientation
				$dompdf->setPaper('A4', 'landscape');
				// Render the HTML as PDF
				$dompdf->render();
				// Output the generated PDF to Browser
				$dompdf->stream('PECOSA_'.$comite['nombreComite'].'_'.$fecha.'.pdf',array('Attachment'=>0));
				exit;
			}else{
				header('location: ../../error');
				exit;
			}
		}else{
			header('location: ../../error');
			exit;
		}
	}
?>