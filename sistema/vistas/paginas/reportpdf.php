<?php
	if (empty($_SESSION['validarUsuarioPvl'])) {
		header('location: ../');
	}
	//require_once 'pdf/vendor/autoload.php';
	require 'reporte/vendor/autoload.php';
	use Dompdf\Options;
	use Dompdf\Dompdf;
	if (empty($_GET['post']) || empty($_GET['ins'])) {
		echo "No es posible generar la factura.";
	}else{
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$idMunicipalidad = trim($idMunicipalidad);
		$municipalidad = ControladorMunicipalidad::ctrMostrarMunicipalidad($idMunicipalidad);
		$nombreMun = str_replace(' ', '-', $municipalidad['nombreMunicipalidad']);
		$nombreArchivo = strtoupper($report).'-'.$nombreMun;
		$table = '';
		$style="padding: 1mm; mso-number-format:'@';";
		$tituloArchivo = '';
		$tit = '';
		if ($report == 'productos') {
			$respuesta = ControladorProducto::ctrReporteProducto($idMunicipalidad);	
			$titulo = array('Nro', 'CODIGO', 'PRODUCTO', 'MARCA', 'DESCRIPCION', 'PROVEEDOR', 'RUC', 'CANTIDAD', 'FECHA REC', 'PRECIO', 'PESO', 'T. PESO', 'T. PERCIO', 'USUARIO REG');
			foreach ($respuesta as $key => $value) {
				$table .= ' 
					<tr >
						<td style="padding: 1mm; text-align: center;">'.($key+1).'</td>	
						<td style="'.$style.'">'.strval($value['codigoProducto']).'</td>
						<td style="padding: 1mm; text-align: center;">'.$value['nombreProducto'].'</td>		
						<td style="padding: 1mm; text-align: center;">'.$value['marcaProducto'].'</td>		
						<td style="padding: 1mm;">'.$value['descripcionProducto'].'</td>		
						<td style="padding: 1mm; text-align: center;">'.$value['nombreProveedor'].'</td>		
						<td style="'.$style.'">'.strval($value['rucProveedor']).'</td>		
						<td style="padding: 1mm; text-align: center;">'.$value['cantidad'].'</td>		
						<td style="padding: 1mm; text-align: center;">'.$value['fechaRecepcion'].'</td>		
						<td style="padding: 1mm; text-align: center;">'.number_format($value['precioUnidad'],2).'</td>		
						<td style="padding: 1mm; text-align: center;">'.number_format($value['pesoUnidad'], 2).'</td>		
						<td style="padding: 1mm; text-align: center;">'.number_format($value['pesoUnidad'] * $value['cantidad'], 2).'</td>		
						<td style="padding: 1mm; text-align: center;">'.number_format($value['precioUnidad'] * $value['cantidad'], 2).'</td>		
						<td style="padding: 1mm; text-align: center;">'.$value['nombrePersona'].' '.$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].'</td>
					</tr>
				';
			}
			$tituloArchivo = $municipalidad['nombreMunicipalidad'].' - '.strtoupper($report);
		}else if($report == 'beneficiarios'){
			$respuesta = ControladorBeneficiario::ctrReporteBeneficiario($idMunicipalidad);		
			$titulo = array('Nro', 'DNI', 'BENEFICIARIO', 'DIRECCION', 'DIR DESCRIPCION', 'NACIMIENTO', 'SEXO', 'DESCRIPCION', 'TIPO BENEF', 'SOCIO', 'INSCRIPCION', 'VENCIMIENTO',  'COMITE', 'LOCALIDAD', 'ESTADO');
			foreach ($respuesta as $key => $value) {
				if ($value['fechaVencimiento'] != null) {
					$fechaVen = $value['fechaVencimiento'];
				}else{
					$fechaVen = "Indefinido";
				}
				$dni = strval($value['dni']);
				$table .= ' 
					<tr >
						<td style="padding: 1mm; text-align: center;">'.($key+1).'</td>		
						<td style="'.$style.'">'.$dni.'</td>		
						<td style="'.$style.'">'.$value['apPaterno'].' '.$value['apMaterno'].', '.$value['nombre'].'</td>		
						<td style="'.$style.'">'.$value['nombreDireccion'].' Nro. '.$value['numero'].'</td>		
						<td style="'.$style.'">'.$value['dirDescripcion'].'</td>		
						<td style="padding: 1mm;">'.$value['fechaNacimiento'].'</td>		
						<td style="'.$style.'">'.$value['sexoPostulante'].'</td>		
						<td style="'.$style.'">'.$value['descripcionPostulante'].'</td>		
						<td style="'.$style.'">'.$value['nombreTipoBeneficiario'].'</td>		
						<td style="'.$style.'">'.$value['socioPaterno'].' '.$value['socioMaterno'].', '.$value['socioNombre'].'</td>			
						<td style="padding: 1mm;">'.$value['fechaInscripcion'].'</td>		
						<td style="padding: 1mm;">'.$fechaVen.'</td>		
						<td style="'.$style.'">'.$value['nombreComite'].'</td>		
						<td style="'.$style.'">'.$value['nombreLocalidad'].'</td>		
						<td style="'.$style.'">'.$value['nombreEstadoBeneficiario'].'</td>
					</tr>
				';
			}
			$tituloArchivo = $municipalidad['nombreMunicipalidad'].' - '.strtoupper($report);
		}else if($report == 'postulantes'){
			$respuesta = ControladorPostulante::ctrReportePostulante($idMunicipalidad);		
			$titulo = array('Nro', 'DNI', 'POSTULANTE', 'DIRECCION', 'DIR DESCRIPCION', 'NACIMIENTO', 'SEXO', 'DESCRIPCION', 'TIPO BENEF', 'SOCIO', 'REGISTRO', 'COMITE', 'LOCALIDAD', 'ESTADO');
			foreach ($respuesta as $key => $value) {
				if ($value['estadoInscripcion'] == 1) {
					$estado = 'RECIBIDO';
				}else if ($value['estadoInscripcion'] == 2) {
					$estado = 'ACEPTADO';
				}else{
					$estado = 'RECHAZADO';
				}
				$dni = strval($value['dni']);
				$table .= ' 
					<tr >
						<td style="padding: 1mm; text-align: center;">'.($key+1).'</td>		
						<td style="'.$style.'">'.$dni.'</td>		
						<td style="'.$style.'">'.$value['apPaterno'].' '.$value['apMaterno'].', '.$value['nombre'].'</td>		
						<td style="'.$style.'">'.$value['nombreDireccion'].' Nro. '.$value['numero'].'</td>		
						<td style="'.$style.'">'.$value['dirDescripcion'].'</td>		
						<td style="padding: 1mm;">'.$value['fechaNacimiento'].'</td>		
						<td style="'.$style.'">'.$value['sexoPostulante'].'</td>		
						<td style="'.$style.'">'.$value['descripcionPostulante'].'</td>		
						<td style="'.$style.'">'.$value['nombreTipoBeneficiario'].'</td>		
						<td style="'.$style.'">'.$value['socioPaterno'].' '.$value['socioMaterno'].', '.$value['socioNombre'].'</td>			
						<td style="padding: 1mm;">'.$value['fechaRegistro'].'</td>			
						<td style="'.$style.'">'.$value['nombreComite'].'</td>		
						<td style="'.$style.'">'.$value['nombreLocalidad'].'</td>		
						<td style="'.$style.'">'.$estado.'</td>		
					</tr>
				';
			}
			$tituloArchivo = $municipalidad['nombreMunicipalidad'].' - '.strtoupper($report);
		}else if ($report == 'salidas') {
			$mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$respuesta = ControladorAlmacen::ctrReporteSalidas($idMunicipalidad);		
			$titulo = array('Nro', 'LOCALIDAD', 'COMITE', 'CODIGO', 'PRODUCTO', 'MARCA', 'CANTIDAD', 'SALIDA', 'AÑO - MES', 'OBSERVACION', 'USUARIO');
			foreach ($respuesta as $key => $value) {
				$mesYear = $mes[$value['mes']-1].' - '.$value['y'];		
				$table .= ' 
					<tr >
						<td style="padding: 1mm; text-align: center;">'.($key+1).'</td>		
						<td style="'.$style.'">'.$value['nombreLocalidad'].'</td>
						<td style="'.$style.'">'.$value['nombreComite'].'</td>		
						<td style="'.$style.'">'.strval($value['codigoProducto']).'</td>		
						<td style="padding: 1mm;">'.$value['nombreProducto'].'</td>		
						<td style="padding: 1mm;">'.$value['marcaProducto'].'</td>		
						<td style="padding: 1mm; text-align: center;">'.$value['cantidad'].'</td>		
						<td style="padding: 1mm;">'.$value['fechaEntrega'].'</td>		
						<td style="'.$style.'">'.$mesYear.'</td>		
						<td style="padding: 1mm;">'.$value['observacion'].'</td>		
						<td style="'.$style.'">'.$value['nombrePersona'].' '.$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].'</td>		
					</tr>
				';
			}
			$tituloArchivo = $municipalidad['nombreMunicipalidad'].' - '.strtoupper($report);
		}else if($report == 'comites'){
			$respuesta = ControladorComite::ctrMostrarComites($idMunicipalidad);
			$titulo = array('Nro', 'LOCALIDAD', 'COMITE', 'DIRECCION', 'DESCRIPCION', 'PRESIDENTE', 'ESTADO');
			foreach ($respuesta as $key => $value) {
				if ($value['estadoComite'] == 1) {
					$estado = "Activo";
				}else{
					$estado = "Inactivo";
				}
				$presidentes = ControladorPresidente::ctrMostrarPresidente('idComitePresidente', $value['idComite']);
				$presidente = 'INDEFINIDO';
				if (!empty($presidentes)) {
					$presidente = $presidentes['apellidoPaternoPersona'].' '.$presidentes['apellidoMaternoPersona'].', '.$presidentes['nombrePersona'];
				}
				$table .= ' 
					<tr >
						<td style="padding: 1mm; text-align: center;">'.($key+1).'</td>		
						<td style="padding: 1mm;">'.$value['nombreLocalidad'].'</td>
						<td style="padding: 1mm;">'.$value['nombreComite'].'</td>		
						<td style="padding: 1mm;">'.$value['direccionComite'].'</td>			
						<td style="padding: 1mm;">'.$value['descripcionComite'].'</td>		
						<td style="padding: 1mm;">'.utf8_encode($presidente).'</td>			
						<td style="'.$style.'">'.$estado.'</td>		
					</tr>
				';
			}
			$tituloArchivo = $municipalidad['nombreMunicipalidad'].' - '.strtoupper($report);
		}else if($report == 'presidentes'){
			$respuesta = ControladorPresidente::ctrMostrarPresidentes('', '', $idMunicipalidad);
			$titulo = array('Nro', 'PRESIDENTE', 'DNI', 'DIRECCION', 'CORREO', 'CELULAR', 'FECHA', 'COMITE', 'LOCALIDAD', 'ESTADO');
			foreach ($respuesta as $key => $value) {
				if ($value['idDireccion'] == null) {
					$direccion = '';
				}else{
					$direccion = $value['nombreDireccion'].' N° '.$value['numero'];
				}
				if ($value['estadoPresidente'] == 1) {
					$estado = "Activo";
				}else{
					$estado = "Inactivo";
				}
				$dni = strval($value['dniPersona']);
				$presidente = $value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].', '.$value['nombrePersona'];
				$table .= ' 
					<tr >
						<td style="padding: 1mm; text-align: center;">'.($key+1).'</td>		
						<td style="padding: 1mm;">'.$presidente.'</td>			
						<td style="'.$style.'">'.$dni.'</td>	
						<td style="padding: 1mm;">'.$direccion.'</td>			
						<td style="padding: 1mm;">'.$value['correoPresidente'].'</td>		
						<td style="'.$style.'">'.$value['celularPresidente'].'</td>		
						<td style="padding: 1mm;">'.$value['fechaRegistroPresidente'].'</td>		
						<td style="padding: 1mm;">'.$value['nombreLocalidad'].'</td>
						<td style="padding: 1mm;">'.$value['nombreComite'].'</td>		
						<td style="'.$style.'"><strong>'.$estado.'</strong></td>			
					</tr>
				';
			}
			$tituloArchivo = $municipalidad['nombreMunicipalidad'].' - '.strtoupper($report);
		}else if($report == 'socios'){
			$respuesta = ControladorSocio::ctrListarSocios($idMunicipalidad, '');
			$titulo = array('Nro', 'SOCIO', 'DNI', 'DIRECCION', 'DESCRIPCION', 'CORREO', 'CELULAR', 'ESTADO');
			foreach ($respuesta as $key => $value) {
				if ($value['idDireccion'] == null) {
					$direccion = '';
				}else{
					$direccion = $value['nombreDireccion'].' N° '.$value['numero'];
				}
				if ($value['estadoSocio'] == 1) {
					$estado = "Activo";
				}else{
					$estado = "Inactivo";
				}
				$dni = strval($value['dniPersona']);
				$socio = $value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].', '.$value['nombrePersona'];
				$table .= ' 
					<tr>
						<td style="padding: 4px; text-align: center;">'.($key+1).'</td>				
						<td style="padding: 4px;">'.$socio.'</td>			
						<td style="'.$style.'">'.$dni.'</td>	
						<td style="padding: 4px;">'.$direccion.'</td>			
						<td style="padding: 4px;">'.$value['descripcion'].'</td>		
						<td style="padding: 4px;">'.$value['correoSocio'].'</td>		
						<td style="'.$style.'">'.$value['celular'].'</td>		
						<td style="'.$style.'"><strong>'.$estado.'</strong></td>			
					</tr>
				';
			}
			$tituloArchivo = $municipalidad['nombreMunicipalidad'].' - '.strtoupper($report);
		}	
		ob_start();
		include(dirname('__FILE__').'/pdfExport.php');
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
		$dompdf->stream('ficha_pdf.pdf',array('Attachment'=>0));

		exit;
	}
 ?>
