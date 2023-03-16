<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="vistas/css/pdf.css">
</head>
<body>
    <h1 style="font-family: Arial; text-align: center; padding: 0; margin: 0;"><?php  echo $tituloArchivo; ?></h1>
    <div  style="text-align: center; padding: 0; margin: 0;">
        <p><?php echo $municipalidad['direccionMunicipalidad']; ?><br>RUC: <?php echo $municipalidad['ruc']; ?></p>
    </div>
    <table border="1" style="width: 100%; font-size: 2.7mm; margin: 0; padding: 0; border-collapse: collapse; font-family: Arial;">
        <thead style="text-align: center;">
            <tr>
                <?php 
                    $total = count($titulo);
                    for ($i = 0; $i < $total; $i++) { 
                ?>
                    <th style="padding: 1mm;"><?php echo $titulo[$i]; ?></th>
                <?php
                    }
                 ?>
            </tr>
        </thead>
        <tbody> 
            <?php echo $table; ?>
        </tbody>
    </table>
    <footer style="width: 100%;"><p style="text-align: center;">Exportado desde www.tupvl.com</p></footer>
</body>
