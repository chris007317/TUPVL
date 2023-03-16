<?php
	$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
	$municipalidad = ControladorMunicipalidad::ctrMostrarMunicipalidad($idMunicipalidad);
	$nombreMun = str_replace(' ', '-', $municipalidad['nombreMunicipalidad']);
	header("Pragma: public");
	header("Expires: 0");	
	$nombreArchivo = strtoupper($report).'-'.$nombreMun.'.xls';
	header("Content-type: application/x-msdownload");
	header("Content-Disposition: attachment; filename=$nombreArchivo");
	header("Pragma: no-cache");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

	//header('Content-type:application/xls; charset=UTF-8');
	//header("Content-type: application/vnd.ms-excel");
	//header('Content-Disposition: attachment; filename='.$nombreArchivo.'.xls');
//	header("Pragma: no-cache");
//	header("Expires: 0");
	$style="padding: 4px; mso-number-format:'@';";
	$table = '';
	if ($report == 'productos') {
		$respuesta = ControladorProducto::ctrReporteProducto($idMunicipalidad);		
		$titulo = array('Nro', 'CODIGO', 'PRODUCTO', 'MARCA', 'DESCRIPCION', 'PROVEEDOR', 'RUC', 'CANTIDAD', 'FECHA REC', 'PRECIO', 'PESO', 'T. PESO', 'T. PERCIO', 'USUARIO REG');
		foreach ($respuesta as $key => $value) {
			$table .= ' 
				<tr >
					<td style="padding: 4px; text-align: center;">'.($key+1).'</td>		
					<td style="'.$style.'">'.strval($value['codigoProducto']).'</td>		
					<td style="padding: 4px; text-align: center;">'.utf8_decode($value['nombreProducto']).'</td>		
					<td style="padding: 4px; text-align: center;">'.utf8_decode($value['marcaProducto']).'</td>		
					<td style="padding: 4px; text-align: center;">'.utf8_decode($value['descripcionProducto']).'</td>		
					<td style="padding: 4px; text-align: center;">'.utf8_decode($value['nombreProveedor']).'</td>		
					<td style="'.$style.'">'.strval($value['rucProveedor']).'</td>		
					<td style="padding: 4px; text-align: center;">'.utf8_decode($value['cantidad']).'</td>		
					<td style="padding: 4px; text-align: center;">'.utf8_decode($value['fechaRecepcion']).'</td>		
					<td style="padding: 4px; text-align: center;">'.utf8_decode($value['precioUnidad']).'</td>		
					<td style="padding: 4px; text-align: center;">'.utf8_decode($value['pesoUnidad']).'</td>		
					<td style="padding: 4px; text-align: center;">'.$value['precioUnidad'] * $value['cantidad'].'</td>		
					<td style="padding: 4px; text-align: center;">'.$value['pesoUnidad'] * $value['cantidad'].'</td>		
					<td style="padding: 4px; text-align: center;">'.utf8_decode($value['nombrePersona'].' '.$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona']).'</td>			
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
					<td style="padding: 4px; text-align: center;">'.($key+1).'</td>		
					<td style="'.$style.'">'.$dni.'</td>		
					<td style="'.$style.'">'.utf8_decode($value['apPaterno'].' '.$value['apMaterno'].', '.$value['nombre']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['nombreDireccion'].' Nro. '.$value['numero']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['dirDescripcion']).'</td>		
					<td style="padding: 4px;">'.utf8_decode($value['fechaNacimiento']).'</td>		
					<td style="'.$style.'">'.utf8_encode($value['sexoPostulante']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['descripcionPostulante']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['nombreTipoBeneficiario']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['socioPaterno'].' '.$value['socioMaterno'].', '.$value['socioNombre']).'</td>			
					<td style="padding: 4px;">'.utf8_decode($value['fechaInscripcion']).'</td>		
					<td style="padding: 4px;">'.utf8_decode($fechaVen).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['nombreComite']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['nombreLocalidad']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['nombreEstadoBeneficiario']).'</td>			
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
					<td style="padding: 4px; text-align: center;">'.($key+1).'</td>		
					<td style="'.$style.'">'.$dni.'</td>		
					<td style="'.$style.'">'.utf8_decode($value['apPaterno'].' '.$value['apMaterno'].', '.$value['nombre']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['nombreDireccion'].' Nro. '.$value['numero']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['dirDescripcion']).'</td>		
					<td style="padding: 4px;">'.utf8_decode($value['fechaNacimiento']).'</td>		
					<td style="'.$style.'">'.utf8_encode($value['sexoPostulante']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['descripcionPostulante']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['nombreTipoBeneficiario']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['socioPaterno'].' '.$value['socioMaterno'].', '.$value['socioNombre']).'</td>			
					<td style="padding: 4px;">'.utf8_decode($value['fechaRegistro']).'</td>			
					<td style="'.$style.'">'.utf8_decode($value['nombreComite']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['nombreLocalidad']).'</td>		
					<td style="'.$style.'">'.$estado.'</td>			
				</tr>
			';
		}
		$tituloArchivo = $municipalidad['nombreMunicipalidad'].' - '.strtoupper($report);
	}else if ($report == 'salidas') {
		$mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$respuesta = ControladorAlmacen::ctrReporteSalidas($idMunicipalidad);		
		$titulo = array('Nro', 'LOCALIDAD', 'COMITE', 'CODIGO', 'PRODUCTO', 'MARCA', 'CANTIDAD', 'SALIDA', 'OBSERVACION', 'AÑO - MES', 'USUARIO');
		foreach ($respuesta as $key => $value) {
			$mesYear = $mes[$value['mes']-1].' - '.$value['y'];		
			$table .= ' 
				<tr >
					<td style="padding: 4px; text-align: center;">'.($key+1).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['nombreComite']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['nombreLocalidad']).'</td>
					<td style="'.$style.'">'.strval($value['codigoProducto']).'</td>		
					<td style="padding: 4px;">'.utf8_decode($value['nombreProducto']).'</td>		
					<td style="padding: 4px;">'.utf8_decode($value['marcaProducto']).'</td>		
					<td style="padding: 4px; text-align: center;">'.utf8_decode($value['cantidad']).'</td>		
					<td style="padding: 4px;">'.utf8_decode($value['fechaEntrega']).'</td>		
					<td style="padding: 4px;">'.utf8_decode($value['observacion']).'</td>		
					<td style="'.$style.'">'.utf8_decode($mesYear).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['nombrePersona'].' '.$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona']).'</td>			
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
					<td style="padding: 4px; text-align: center;">'.($key+1).'</td>		
					<td style="padding: 4px;">'.utf8_decode($value['nombreLocalidad']).'</td>
					<td style="padding: 4px;">'.utf8_decode($value['nombreComite']).'</td>		
					<td style="padding: 4px;">'.utf8_decode($value['direccionComite']).'</td>			
					<td style="padding: 4px;">'.utf8_decode($value['descripcionComite']).'</td>		
					<td style="padding: 4px;">'.utf8_encode($presidente).'</td>			
					<td style="'.$style.'">'.$estado.'</td>			
				</tr>
			';

		}
		$tituloArchivo = $municipalidad['nombreMunicipalidad'].' - '.strtoupper($report);
	}else if($report == 'presidentes'){
		$respuesta = ControladorPresidente::ctrMostrarPresidentes('', '', $idMunicipalidad);
		$titulo = array('Nro', 'LOCALIDAD', 'COMITE', 'PRESIDENTE', 'DNI', 'DIRECCION', 'CORREO', 'CELULAR', 'FECHA', 'ESTADO');
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
					<td style="padding: 4px; text-align: center;">'.($key+1).'</td>		
					<td style="padding: 4px;">'.utf8_decode($value['nombreLocalidad']).'</td>
					<td style="padding: 4px;">'.utf8_decode($value['nombreComite']).'</td>		
					<td style="padding: 4px;">'.utf8_decode($presidente).'</td>			
					<td style="'.$style.'">'.$dni.'</td>	
					<td style="padding: 4px;">'.utf8_decode($direccion).'</td>			
					<td style="padding: 4px;">'.utf8_decode($value['correoPresidente']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['celularPresidente']).'</td>		
					<td style="padding: 4px;">'.utf8_decode($value['fechaRegistroPresidente']).'</td>		
					<td style="'.$style.'">'.$estado.'</td>			
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
					<td style="padding: 4px;">'.utf8_decode($socio).'</td>			
					<td style="'.$style.'">'.$dni.'</td>	
					<td style="padding: 4px;">'.utf8_decode($direccion).'</td>			
					<td style="padding: 4px;">'.utf8_decode($value['descripcion']).'</td>		
					<td style="padding: 4px;">'.utf8_decode($value['correoSocio']).'</td>		
					<td style="'.$style.'">'.utf8_decode($value['celular']).'</td>		
					<td style="'.$style.'">'.$estado.'</td>			
				</tr>
			';

		}
		$tituloArchivo = $municipalidad['nombreMunicipalidad'].' - '.strtoupper($report);
	}		

?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
	<div style="width: 95%;	margin: 15px auto 10px auto;"> 
		<div  style="text-align: center; align-content: center;">
			<h1 style="font-family: Arial"><?php  echo $tituloArchivo; ?></h1>
			<p><?php echo $municipalidad['direccionMunicipalidad']; ?><br>RUC: <?php echo $municipalidad['ruc']; ?></p>
		</div>
	</div>
	<table border="1" style="margin: 0 auto; border-collapse: collapse; font-family: Arial;">
		<thead>
			
			<tr>
				<?php 
					$total = count($titulo);
					for ($i = 0; $i < $total; $i++) { 
				?>
					<th style="padding: 6px;"><?php echo utf8_decode($titulo[$i]); ?></th>
				<?php
					}
				 ?>
			</tr>
		</thead>
		<tbody >
			<?php echo $table; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="<?php echo $total; ?>" style="text-align: center; padding: 4px;">Exportado desde www.tupvl.com</td>
			</tr>
		</tfoot>
	</table>
</body>
