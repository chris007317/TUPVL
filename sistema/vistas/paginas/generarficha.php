<?php 

	if (empty($_SESSION['validarUsuarioPvl'])) {
		header('location: ../');
	}
	//require_once 'pdf/vendor/autoload.php';
	//require_once 'reporte/vendor/autoload.php';
	//require 'reporte/vendor/autoload.php';
	require 'reporte/vendor/autoload.php';
	use Dompdf\Dompdf;
	use Dompdf\Options;
	if (empty($_GET['post']) || empty($_GET['ins'])) {
		echo "No es posible generar la factura.";
	}else{
		$idPostulante = $_REQUEST['post'];
		$idInscripcion = $_REQUEST['ins'];
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$inscripcion = ControladorInscripcion::ctrMostrarInscripcion('idInscripcion', $idInscripcion);
		if ($inscripcion['idPostulante'] == $idPostulante) {
			$postulante = ControladorPostulante::ctrMostrarPostulante('idPostulante', $idPostulante);
			$direccionPost = ControladorDireccion::ctrMostrarDireccion($postulante['idDireccion']);			
			$localidad = ControladorLocalidad::ctrMostrarLocalidad($inscripcion['idLocalidadComite']);
			$socio = ControladorSocio::ctrMostrarSocio('idSocio', $inscripcion['idSocioInscripcion'], $idMunicipalidad);
			$direccionSocio = ControladorDireccion::ctrMostrarDireccion($socio['idDireccion']);			
			$responsable = ControladorMunicipalidad::ctrMostrarrResponsbleMunicipalidad($idMunicipalidad);
			$usuario = ControladorUsuario::ctrMostrarDatosUsuario($inscripcion['idUsuarioInscripcion']);
			
			$requistos = ControladorRequisitoMunicipalidad::ctrMostrarRequisitoMunicipalidad($idMunicipalidad, $inscripcion['idTipoInscripcion']);
			$requCumplidos = ControladorInscripcion::ctrMostrarRequisitosInscripcion($idInscripcion);
			$estadoInscripcion = '';
			if ($inscripcion['estadoInscripcion'] == 1) {
				$estadoInscripcion = 'Registrado';
			}else if ($inscripcion['estadoInscripcion'] == 0) {
				$estadoInscripcion = 'Rechazado';
			}else if($inscripcion['estadoInscripcion'] == 2){
				$estadoInscripcion = 'Aceptado';
			}
			$edad = calcularEdad($postulante['fechaNacimiento']);
			$rutaImg = '';
			if ($responsable['imagenMunicipalidad']=='img/municipalidades/municpalidad.png') {
				$rutaImg = '';
			}else{
				$rutaImg = '<img class="img-muni" src="'.$rutaSistema.'vistas/'.$responsable['imagenMunicipalidad'].'">';
			}
			ob_start();
		    include(dirname('__FILE__').'/ficha.php');
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
			$dompdf->stream('ficha_'.$postulante['apellidoPaternoPersona'].'_'.$postulante['apellidoMaternoPersona'].'.pdf',array('Attachment'=>0));
			exit;
		}else{
			echo "No es posible generar la ficha.";	
		}

	}
 ?>