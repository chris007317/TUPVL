<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<title>Pecosa</title>
		<link rel="stylesheet" href="<?php echo $rutaSistema; ?>vistas/css/estiloPecosa.css">
	</head>
	<body style="margin: 15mm 8mm 10mm 8mm;"> 
		<div style="margin: 0; padding: 0;">
			<p class="textcenter h1">PADRON DE DISTRIBUCIÓN DE PRODUCTOS DE VASO DE LECHE</p>
			<table id="factura_head">
				<tr>
					<td class="logo_factura">
						<div class="img-cont">
							<?php echo $rutaImg; ?>
						</div>
					</td>
					<td style="width: 60%;">
						<div class="textcenter">
							<span class="h2">COMITÉ: <?php echo mb_strtoupper($comite['nombreComite']); ?></span>
							<p class="h3">PRODUCTOS: <?php echo substr($productos, 0, -2);; ?></p>
							<p>FECHA DE ENTREGA: <?php echo $dia.'/'.$m.'/'.$y; ?></p>
						</div>
					</td>
					<td style="width: 20%;">
						<div>
							<p class="h2">FOLIO</p>
							<p>CANTIDAD: <?php echo $cont2; ?></p>
							<p>FECHA: <?php echo $dia.'/'.$m.'/'.$y; ?></p>
						</div>

					</td>
				</tr>
			</table>
			<table class="tbPadron" border="1">
				<thead>
					<tr>
						<th style="width: 10%;">N°</th>
						<th style="width: 43%;">APELLIDOS Y NOMBRES DEL BENEFICIARIO</th>
						<th style="width: 9%;">LECHE</th>
						<th style="width: 9%;">AVENA</th>
						<th style="width: 10%;">DNI</th>
						<th style="width: 19%;">FIRMA Y/O HUELLA</th>
					</tr>
				</thead>
				<tbody style="border: 1px solid; border-collapse: collapse;">
					<?php foreach ($padronBenef as $key => $value): ?>
						<tr>
							<td style="border: 1px solid; text-align: right;"><p><?php echo $key+1; ?></p></td>
							<td style="border: 1px solid;"><p><?php echo $value['beneficiario']; ?></p></td>
							<td style="border: 1px solid; text-align: right;"><p><?php echo ($cantLeche/$cont2); ?></p></td>
							<td style="border: 1px solid; text-align: right;"><p><?php echo ($cantAvena/$cont2); ?></p></td>
							<td style="border: 1px solid; text-align: right;"><p><?php echo $value['dni']; ?></p></td>
							<td  style="border: 1px solid;"></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</body>
</html>