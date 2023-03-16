<?php 
	session_start();
	$ruta = ControladorRuta::ctrRuta();
	if (isset($_SESSION['idAdmin'])) {
		$datosAdmin = ControladorAdminsitrador::ctrMostrarAdministrador($_SESSION['idAdmin']);	
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="description" content="Login Tu PVL">
	<meta name="autor" content="JusviSoft">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Sistema TU PVL</title>
    <meta name="theme-color" content="#003688">	<link rel="icon" href="../sistema/vistas/img/favicon.png">
	
	<!--====  VINCULOS CSS  ====-->
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<!-- scrooll -->
	<link rel="stylesheet" type="text/css" href="vistas/css/plugins/OverlayScrollbars.min.css">
	<!-- css AdminLT E-->
	<link rel="stylesheet" type="text/css" href="vistas/css/plugins/adminlte.min.css">
	<!-- estilo echo -->
	<link rel="stylesheet" type="text/css" href="vistas/css/estilos.css">
	
	
	<!--====  VINCULOS JAVASCRIPT  ====-->
	
	<!-- FontAwesome -->	
	<script type="text/javascript" src="vistas/js/plugins/fontawesome-all.min.js"></script>

	 <!-- JQuery -->
	<script type="text/javascript" src="vistas/js/plugins/jquery-3.5.1.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<!-- bootstrap -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<!-- AdminLTE -->
	<script type="text/javascript" src="vistas/js/plugins/adminlte.min.js"></script>
	<!-- Sweetalert2 -->
	<script type="text/javascript" src="vistas/js/plugins/sweetalert2.all.js"></script>
	

</head>
 <?php if (!isset($_SESSION['validarInicioAdmin'])): 
 	include 'paginas/login.php';
 ?>
<?php else: ?>
<body  class="hold-transition sidebar-mini ">
	<div class="wrapper">
		<?php 
			include "paginas/modulos/header.php";
			include "paginas/modulos/menu.php";
			if (isset($_GET['pagina'])) {
				if ($_GET['pagina'] == 'inicio' || $_GET['pagina'] == 'municipalidades' || $_GET['pagina'] == 'propuestas' || $_GET['pagina'] == 'responsables' |$_GET['pagina'] == 'salir') {
					include 'paginas/'.$_GET['pagina'].'.php';
				}else{
					include 'paginas/error404.php';
				}
			}else{
				include 'paginas/inicio.php';
			}
			include "paginas/modulos/footer.php";
		 ?>
	</div>
	<script type="text/javascript" src="vistas/js/propuestas.js"></script>
</body>
<?php endif ?>
</html>