<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<link rel="icon" href="<?php echo $rutaSistema; ?>vistas/img/favicon.png">
		<meta charset="utf-8">
		<title>Pecosa</title>
		<link rel="stylesheet" href="<?php echo $rutaSistema; ?>vistas/css/estiloPecosa.css">
	</head>
	<body>
		<div id="page_pdf">
			<table id="factura_head">
				<tr>
					<td class="logo_factura">
						<div class="img-cont">
							<?php echo $rutaImg; ?>
						</div>
						<div>
							<p><?php echo $responsable['nombreMunicipalidad']; ?></p>
							<p><?php echo $responsable['direccionMunicipalidad']; ?></p>
							<strong>R.U.C: <?php echo $responsable['ruc'] ?></strong>
						</div>
					</td>
					<td class="info_empresa">
						<div class="textcenter">
							<span class="h2">PEDIDO COMPROBANTE DE SALIDA-PECOSA</span>
							<p class="h2"><?php echo strtoupper($comite['nombreComite']); ?></p>
							<p>NOMBRE DEL COMITÉ</p>
						</div>
					</td>
					<td>
						<ul style="list-style: none;">
							<li style="float: left; width: 25%; border: 1px solid; text-align: center; height: 40px;"><div>NUMERO</div><hr><div></div></li>
							<li style="float: left; width: 25%; border: 1px solid; text-align: center; height: 40px;"><div>DIA</div><hr><div><?php echo $dia; ?></div></li>
							<li style="float: left; width: 25%; border: 1px solid; text-align: center; height: 40px;"><div>MES</div><hr><div><?php echo $mes; ?></div></li>
							<li style="float: left; width: 25%; border: 1px solid; text-align: center; height: 40px;"><div>AÑO</div><hr><div><?php echo $y; ?></div></li>
						</ul>

					</td>
				</tr>
				<tr>
					<td class="textright">
						<p>DEPENDECIA SOLICITANTE: </p>
					</td>
					<td class="textleft ml5" colspan="2">
						<p><?php echo strtoupper($comite['nombreComite']); ?></p>
					</td>
				</tr>
				<tr>
					<td class="textright">
						<p>SOLICITO ENTREGAR A: </p>
					</td>
					<td class="textleft ml5" colspan="2">
						<p><?php echo $presidente['apellidoPaternoPersona'].' '.$presidente['apellidoMaternoPersona'].' '.$presidente['nombrePersona']; ?></p>
					</td>
				</tr>
				<tr>
					<td class="textright">
						<p>CON DESTIONO A: </p>
					</td>
					<td class="textleft ml5" colspan="2">
						<p><?php echo strtoupper($comite['direccionComite'].' N° '.$comite['numeroCalle']); ?></p>
					</td>
				</tr>
			</table>
			<table style="width: 100%; padding: 0; margin: 0;">
				<tr>
					<td style="width: 60%; text-align: center;"><strong>PRODUCTOS</strong></td>
					<td style="width: 20%;">
						<P>ORDEN DE DESPACHO</P>
					</td>
					<td style="width: 20%;">
						<P>FECHA: <?php echo $dia.'/'.$mes.'/'.$y; ?></P>
					</td>
				</tr>
			</table>
			<table class="tbpecosa" border="1">
				<thead>
					<tr>
						<th style="width: 10%;">Cantidades</th>
						<th style="width: 40%;">Descripción</th>
						<th style="width: 10%;">Codigo</th>
						<th style="width: 10%;">Cantidad</th>
						<th style="width: 10%;">Prec. Unitario</th>
						<th style="width: 10%;">Total</th>
					</tr>
				</thead>
				<tbody style="border: 1px solid; border-collapse: collapse;">
					<?php foreach ($pecosas as $key => $value): ?>
						<tr>
							<td style="border: 1px solid; text-align: center;"><?php echo $value['cantidad']; ?></td>
							<td style="border: 1px solid; text-align: center;"><?php echo $value['nombreProducto'].' - '.$value['marcaProducto']; ?></td>
							<td style="border: 1px solid; text-align: center;"><?php echo $value['codigoProducto']; ?></td>
							<td style="border: 1px solid; text-align: right; padding-right: 5px;"><?php echo $value['cantidad']; ?></td>
							<td style="border: 1px solid;">
								<div style="display: flex; height: 20px;">
									<div style="width: 20%; padding-left: 5px;"><span>S/.</span></div><div style="width: 80%; text-align: right;"><?php echo $value['precioUnidad']; ?></div>
								</div>
							</td>
							<td  style="border: 1px solid;">
								<div style="display: flex; height: 20px;">
									<div style="width: 20%; padding-left: 5px;"><span>S/.</span></div><div style="width: 80%; text-align: right;"><?php echo $value['total']; ?></div>
								</div>
							</td>
						</tr>
						<?php
							 $total = $value['total'] + $total;
							 $cont++;
						 ?>
					<?php endforeach ?>
				</tbody>
				<?php $numTotal = number_format($total, 2); 
				$v=new CifrasEnLetras(); 
				//Convertimos el total en letras
				$letra=($v->convertirEurosEnLetras($total));
				?>
				<tfoot>
					<tr>
						<td colspan="5" class="textcenter">SON: <?php echo mb_strtoupper($letra); ?></td>
						<td>
							<div style="display: flex; height: 20px;">
								<div style="width: 20%; padding-left: 5px;"><span>S/.</span></div><div style="width: 80%; text-align: right;"><?php echo $numTotal; ?></div>
							</div>
						</td>
					</tr>
				</tfoot>
			</table>
			<table style="width: 100%; margin-top: 20px;">
				<tr>
					<td style="width: 20%;"><div>Cuentas del Mayor</div></td>
					<td style="width: 20%;">
						<div style="width: 80%;">
							<div class="cuadro"></div><div class="cuadro-linea"><hr class="linea-cuad"></div>
						</div>
					</td>
					<td style="width: 20%;">
						<div style="width: 80%;">
							<div class="cuadro"></div><div class="cuadro-linea"><hr class="linea-cuad"></div>
						</div>
					</td>
					<td style="width: 40%;">
						<div style="text-align: center;"><p>CANTIDAD</p>
							<h2><?php echo $cont; ?></h2>
						</div>
					</td>
				</tr>
				<tr>
					<td style="width: 20%;">
						<div style="width: 80%;">
							<div class="cuadro"></div><div class="cuadro-linea"><hr class="linea-cuad"></div>
						</div>
					</td>
					<td style="width: 20%;">
						<div style="width: 80%;">
							<div class="cuadro"></div><div class="cuadro-linea"><hr class="linea-cuad"></div>
						</div>
					</td>
					<td style="width: 20%;">
						<div style="width: 80%;">
							<div class="cuadro"></div><div class="cuadro-linea"><hr class="linea-cuad"></div>
						</div>
					</td>
					<td style="width: 40%;">
						<div style="text-align: center;">
							<hr style="width: 150px; margin-left: auto; margin-right: auto;">
							<p>(Cantidad de Items)</p>
						</div>
					</td>
				</tr>
			</table>
			<table style="width: 100%; text-align: center; padding-top: 100px;">
				<tr>
					<td style="width: 25%;"><hr class="linea">Administrador de PVL</td>
					<td style="width: 25%;"><hr class="linea">Jefe de Almacen</td>
					<td style="width: 25%;"><hr class="linea">Digitador</td>
					<td style="width: 25%;">
						<hr class="linea">
						<p>Recibí conforme - Solicitante</p>
					</td>
				</tr>
				<tr><td colspan="4" class="textright"><p>DNI.................................... Fecha de recepción ....../....../.........</p></td></tr>
			</table>
		</div>
	</body>
</html>