<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo $rutaSistema; ?>vistas/css/estiloRegistro.css">
</head>
<body>
	<?php if ($inscripcion['estadoInscripcion'] == 0): ?>
		<img class="anulada" src="<?php echo $rutaSistema; ?>vistas/img/anulado.png" alt="Anulada">		
	<?php endif ?>
	<div id="page_pdf">
		<table id="factura_head">
			<tr>
				<td class="logo_factura">
					<div>
						<?php echo $rutaImg; ?>
					</div>
				</td>
				<td class="info_empresa">
					<div>
						<span class="h2"><?php echo $responsable['nombreMunicipalidad']; ?></span>
						<p><?php echo $responsable['direccionMunicipalidad']; ?></p>
						<p>RUC: <?php echo $responsable['ruc']; ?></p>
						<p>Responsable: <?php echo $responsable['apellidoPaternoPersona'].' '.$responsable['apellidoMaternoPersona'].', '.$responsable['nombrePersona']; ?></p>
					</div>
				</td>
				<td class="info_factura">
					<div class="round">
						<span class="h3">Inscripción</span>
						<p>Fecha: <?php echo $inscripcion['fechaInscripcion']; ?></p>
						<p>Hora: <?php echo $inscripcion['horaRegistro']; ?></p>
						<p>Usuario: <?php echo $usuario['apellidoPaternoPersona'].' '.$usuario['apellidoMaternoPersona'].', '.$usuario['nombrePersona']; ?></p>
					</div>
				</td>
			</tr>
		</table>

		<table id="factura_cliente">
			<tr>
				<td class="info_cliente">
					<div class="round">
						<span class="h3">Datos Socio</span>
						<table class="datos_cliente">
							<tr>
								<td><label>Apellidos y nombres:</label><p><?php echo $socio['apellidoPaternoPersona'].' '.$socio['apellidoMaternoPersona'].', '.$socio['nombrePersona']; ?></p></td>
								<td><label>DNI:</label> <p><?php echo $socio['dniPersona']; ?></p></td>
								<td><label>Ubicación:</label><p><?php echo $direccionSocio['nombreDepartamento'].', '.$direccionSocio['nombreProvincia'].', '.$direccionSocio['nombreDistrito']; ?></p></td>
							</tr>
							<tr>
								<td><label>Dirección:</label> <p><?php echo $direccionSocio['nombreDireccion'].' N° '.$direccionSocio['numero']; ?></p></td>
								<td><label>Celular:</label> <p><?php echo $socio['celular']; ?></p></td>
								<td><label>Correo:</label> <p><?php echo $socio['correoSocio']; ?></p></td>
							</tr>

						</table>
					</div>
				</td>

			</tr>
		</table>

		<table id="factura_cliente">
			<tr>
				<td class="info_cliente">
					<div class="round">
						<span class="h3">Datos Del Postulante</span>
						<table class="datos-postulante">
							<tr>
								<td><label>Apellidos y nombres:</label><p><?php echo $postulante['apellidoPaternoPersona'].' '.$postulante['apellidoMaternoPersona'].', '.$postulante['nombrePersona']; ?></p></td>
								<td><label>DNI:</label> <p><?php echo $postulante['dniPersona']; ?></p></td>
								<td><label>Ubicación:</label><p><?php echo $direccionPost['nombreDepartamento'].', '.$direccionPost['nombreProvincia'].', '.$direccionPost['nombreDistrito']; ?></p></td>
								<td><label>Sexo:</label><p><?php echo $postulante['sexoPostulante'] ;?></p></td>
							</tr>
							<tr>
								<td><label>Dirección:</label> <p><?php echo $direccionPost['nombreDireccion']; ?></p></td>
								<td><label>Fecha de Nac:</label> <p><?php echo date("d-m-Y", strtotime($postulante['fechaNacimiento'])); ?></p></td>
								<td><label>edad:</label> <p><?php echo $edad; ?></p></td>
								<td><label>Parentesco:</label> <p><?php echo $inscripcion['nombreTipoSocio']; ?></p></td>
							</tr>
							<tr>
								<td><label>Localidad:</label> <p><?php echo $localidad['nombreLocalidad']; ?></p></td>
								<td><label>Comité:</label> <p><?php echo $inscripcion['nombreComite']; ?></p></td>
								<td><label>Postula a:</label> <p><?php echo $inscripcion['nombreTipoBeneficiario']; ?></p></td>
								<td><label>Estado:</label><p><?php echo $estadoInscripcion; ?></p></td>
							</tr>
						</table>
					</div>
				</td>

			</tr>
		</table>

		<table id="factura_detalle">
				<thead>
					<tr>
						<th width="50px">N°</th>
						<th class="textleft" width="250px">Requisitos</th>
						<th class="textleft">descripción</th>
						<th class="textright" width="50px"> Cumple</th>
					</tr>
				</thead>
				<tbody id="detalle_productos">
					<?php 			
						$cumple = 0;
						$req = 0;
						for ($i = 0; $i < count($requistos); $i++) { 
							for ($j = 0; $j < count($requCumplidos); $j++) { 
								if ($requistos[$i]['idReMuni'] == $requCumplidos[$j]['idReMuni']) {
									$req++;
									break;
								}
							}?>
							<tr>
								<td class="textcenter"><?php echo $i+1; ?></td>
								<td><?php echo $requistos[$i]['nombreRequisito']; ?> </td>
								<td class="textleft"><?php echo $requistos[$i]['descripcionRequisito']; ?></td>
							<?php if ($req > 0) {?>
								<td class="textcenter">SI</td>
						<?php 			
								$req = 0;
							}else{
								$cumple++;
						?>
								<td class="textcenter">NO</td>
						<?php	}?>
							</tr>
						<?php
						} 
					?>
				</tbody>
				<tfoot id="detalle_totales">
					<tr>
						<td colspan="3" class="textcenter"><span>Cumple los requisitos</span></td>
						<td class="textcenter"><span><?php if ($cumple == 0): ?>
							SI
						<?php else: ?>
							NO
						<?php endif ?></span></td>
					</tr>
			</tfoot>
		</table>
		<div>
			<p class="nota">Esta ficha solo es informativa, <br>Cualquier consulta comunicarse al administrador de la Municipalidad responsable de la inscripción.</p>
			<h4 class="label_gracias">TuPVL.com ¡Facilita las cosas!</h4>
		</div>

	</div>

</body>
</html>