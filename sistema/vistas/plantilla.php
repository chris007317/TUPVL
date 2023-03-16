<?php 
	session_start();
	date_default_timezone_set('America/Lima');
	$ruta = ControladorRuta::ctrRuta();
	$rutaSistema = ControladorRuta::ctrServidor();
	if (isset($_SESSION['idUsuarioPvl']) && isset($_GET['pagina']) && !empty($_SESSION['idUsuarioPvl'])) {
		if (isset($_GET['post']) && isset($_GET['ins'])) {
			if($_GET['pagina'] == 'generarficha'){
				include 'paginas/'.$_GET['pagina'].'.php';
				return;
			}else if($_GET['pagina'] == 'pecosa'){
				include 'paginas/'.$_GET['pagina'].'.php';
				return;
			}else if($_GET['pagina'] == 'padron'){
				include 'paginas/'.$_GET['pagina'].'.php';
				return;
			}else if($_GET['pagina'] == 'reporte'){
				if ($_GET['post'] == 'reportExcel' && ($_GET['ins'] == 'productos' || $_GET['ins'] == 'beneficiarios' || $_GET['ins'] == 'postulantes' ||
					$_GET['ins'] == 'salidas' || $_GET['ins'] == 'comites' || $_GET['ins'] == 'presidentes' || $_GET['ins'] ==  'socios') ) {
					$report = $_GET['ins'];
					include 'paginas/report.php';
					return;	
				}else if ($_GET['post'] == 'reportPdf' && ($_GET['ins'] == 'productos' || $_GET['ins'] == 'beneficiarios' || $_GET['ins'] == 'postulantes' ||
					$_GET['ins'] == 'salidas' || $_GET['ins'] == 'comites' || $_GET['ins'] == 'presidentes' || $_GET['ins'] ==  'socios') ) {
					$report = $_GET['ins'];
					include 'paginas/reportpdf.php';
					return;	
				}
			}
		}
	}else if (!isset($_SESSION['idUsuarioPvl']) && isset($_GET['pagina']) && isset($_GET['post']) && isset($_GET['ins'])) {
		header('location: ../../');
	}
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
    <meta name="description" content="Login Tu PVL">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="autor" content="JusviSoft">
    <meta name="theme-color" content="#003688">	<link rel="icon" href="vistas/img/favicon.png">
    <!-- JQuery -->
	<script type="text/javascript" src="vistas/js/plugins/jquery-3.5.1.min.js"></script>
	<!-- fontawesome -->
	<script type="text/javascript" src="vistas/js/plugins/fontawesome-all.min.js"></script> 
    <?php if (!isset($_SESSION['validarUsuarioPvl'])): ?>
    	<title>Iniciar Sesión</title>
    	<!--====  VINCULOS CSS  ====-->
		<!-- normalice css -->
		<link rel="stylesheet" type="text/css" href="vistas/css/plugins/normalize.css">
		<!-- archivo css -->
		<link rel="stylesheet" type="text/css" href="vistas/css/estilo-base.css">
		<link rel="stylesheet" type="text/css" href="vistas/css/login.css">
		<link rel="stylesheet" type="text/css" href="vistas/css/nav.css">
		<script type="text/javascript" src="vistas/js/login.js"></script>
			
</head>
		<?php include 'paginas/login.php'; ?>

	<?php else: 


		?>
		<title>Sistema PVL</title>
	  	<!-- Select2 -->
	  	<link rel="stylesheet" type="text/css" href="vistas/css/plugins/select2.all.min.css">
		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">		
		<!-- scrooll -->
		<link rel="stylesheet" type="text/css" href="vistas/css/plugins/OverlayScrollbars.min.css">
	  	<!-- css adminLTE -->
	  	<link rel="stylesheet" type="text/css" href="vistas/css/plugins/adminlte.min.css">
		<!-- Google Font: Source Sans Pro -->
	  	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	  	<!-- data Table -->
	  	<link rel="stylesheet" type="text/css" href="vistas/css/plugins/dataTables.bootstrap4.min.css">
	  	<link rel="stylesheet" type="text/css" href="vistas/css/plugins/responsive.bootstrap4.min.css">
	  	<link rel="stylesheet" type="text/css" href="vistas/css/colores.css">
		<!--=====================================
		VÍNCULOS JAVASCRIPT
		======================================-->
		<!-- Popper JS -->
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
		<!-- adminLTE js -->
		<script type="text/javascript" src="vistas/js/plugins/adminlte.min.js"></script>
		<!-- Sweetalert2 -->
		<script type="text/javascript" src="vistas/js/plugins/sweetalert2.all.js"></script>
		
		<!-- Select2 -->
		<script type="text/javascript" src="vistas/js/plugins/select2.all.min.js"></script>
		<!-- data Table -->
		<script type="text/javascript" src="vistas/js/plugins/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="vistas/js/plugins/dataTables.bootstrap4.min.js"></script>
		<script type="text/javascript" src="vistas/js/plugins/dataTables.responsive.min.js"></script>
		<script type="text/javascript" src="vistas/js/plugins/responsive.bootstrap4.min.js"></script>
		<script type="text/javascript" src="vistas/js/plugins/dashboard3.js"></script>
		<script type="text/javascript" src="vistas/js/plugins/Chart.min.js"></script>
		
</head>
		<body  class="hold-transition sidebar-mini sidebar-collapse">
			<?php 
				$dia = date("w", strtotime("now"));
				$hora = strtotime(date("H:i"));
				//echo '<pre>'; print_r($hora); echo '</pre>';
				if ($dia == 0) {
					session_destroy();
					echo '<script>
							swal({
								type: "warning", 
								title: "¡Advertencia!",
								text: "¡Horario no disponible!",
								showConfirmButton: true,
								confirmButtonText: "aceptar"
							}).then(function(result){
								if(result.value){
									window.location = "'.$rutaSistema.'";
								}	 
							});
						</script>';
				}else{
					if (isset($_SESSION['idUsuarioPvl'])) {
						$datosUsuario = ControladorUsuario::ctrMostrarDatosUsuario($_SESSION['idUsuarioPvl']);
						/*=============================================
						$time = time();
						$fix = $time - 3600;
						$horaEntrada = strtotime($datosUsuario['horaEntrada']);
						$horaSalida = strtotime($datosUsuario['horaSalida']);
						if (($fix < $horaEntrada && $fix > $horaSalida) || ($fix < $horaEntrada && $fix < $horaSalida)) {
							session_destroy();
							echo '<script>
								swal({
									type: "warning", 
									title: "¡Advertencia!",
									text: "Horario disponible de: '.$datosUsuario['horaEntrada'].' horas a '.$datosUsuario['horaSalida'].' horas",
									showConfirmButton: true,
									confirmButtonText: "aceptar"
								}).then(function(result){
									if(result.value){
										window.location = "'.$rutaSistema.'";
									}	 
								});
							</script>';
							exit();
						}

						echo '<pre>'; print_r($horaEntrada); echo '</pre>';
						
						$horaSalida = strtotime($datosUsuario['horaSalida']);
						if ($hora > $horaEntrada ) {
							session_destroy();
							echo '<script>
									swal({
										type: "warning", 
										title: "¡Advertencia!",
										text: "¡Horario no disponible!",
										showConfirmButton: true,
										confirmButtonText: "aceptar"
									}).then(function(result){
										if(result.value){
											window.location = "'.$rutaSistema.'";
										}	 
									});
								</script>';
							exit();	
						}
						
						=============================================*/
						
						
						
						
						
						$nuevosPostuante = ControladorInscripcion::ctrNuevosInscritos($_SESSION['idMunicipalidadPvl']);
						$totalPostulante = ControladorInscripcion::ctrTotalInscritos($_SESSION['idMunicipalidadPvl'], 1);
						$datosBenef = new ControladorBeneficiario();
						$porVencer = $datosBenef->ctrContarBenerfPorVencer($_SESSION['idMunicipalidadPvl']);
						?>
						<div class="wrapper">
						<?php 
							if (isset($_GET['pagina'])) {
								include "paginas/modulos/header.php";
								include "paginas/modulos/menu.php";
								if ($datosUsuario['idTipoUsuario'] == 1 ) {
									if ($_GET['pagina'] == 'inicio' || $_GET['pagina'] == 'municipalidad' || $_GET['pagina'] == 'requisitos' ||
										$_GET['pagina'] == 'tipo-beneficiario' || $_GET['pagina'] == 'alimentos' || $_GET['pagina'] == 'salir' || 
										$_GET['pagina'] == 'proveedores' || $_GET['pagina'] == 'entradas' || $_GET['pagina'] == 'almacen' || 
										$_GET['pagina'] == 'comites' || $_GET['pagina'] == 'presidentes' || $_GET['pagina'] == 'nuevo-postulante' || 
										$_GET['pagina'] == 'postulantes' || $_GET['pagina'] == 'nuevo-beneficiario' || $_GET['pagina'] == 'beneficiarios' ||
										$_GET['pagina'] == 'socios' || $_GET['pagina'] == 'nueva-entrega' || $_GET['pagina'] == 'lista-entregas'||
										$_GET['pagina'] == 'entregar-productos' || $_GET['pagina'] == 'entregados' || $_GET['pagina'] == 'consultas' ||
										$_GET['pagina'] ==  'reportes' || $_GET['pagina'] == 'usuarios'
									) {
										include 'paginas/'.$_GET['pagina'].'.php';
										echo '<script type="text/javascript" src="vistas/js/'.$_GET['pagina'].'.js"></script>';
									}else{
										include 'paginas/error.php';
									}
								}else if ($datosUsuario['idTipoUsuario'] == 2) {
									if ($_GET['pagina'] == 'inicio' || $_GET['pagina'] == 'municipalidad' || $_GET['pagina'] == 'requisitos' ||
										$_GET['pagina'] == 'tipo-beneficiario' || $_GET['pagina'] == 'alimentos' || $_GET['pagina'] == 'salir' || 
										$_GET['pagina'] == 'proveedores' || $_GET['pagina'] == 'entradas' || $_GET['pagina'] == 'almacen' || 
										$_GET['pagina'] == 'comites' || $_GET['pagina'] == 'presidentes' || $_GET['pagina'] == 'nuevo-postulante' || 
										$_GET['pagina'] == 'postulantes' || $_GET['pagina'] == 'nuevo-beneficiario' || $_GET['pagina'] == 'beneficiarios' ||
										$_GET['pagina'] == 'socios' || $_GET['pagina'] == 'nueva-entrega' || $_GET['pagina'] == 'lista-entregas'||
										$_GET['pagina'] == 'entregar-productos' || $_GET['pagina'] == 'entregados' || $_GET['pagina'] == 'consultas'
									) {
										include 'paginas/'.$_GET['pagina'].'.php';
										echo '<script type="text/javascript" src="vistas/js/'.$_GET['pagina'].'.js"></script>';
									}else{
										include 'paginas/error.php';
									}
								}else if ($datosUsuario['idTipoUsuario'] == 3) {
									if ($_GET['pagina'] == 'inicio' || $_GET['pagina'] == 'municipalidad' || $_GET['pagina'] == 'requisitos' ||
										$_GET['pagina'] == 'tipo-beneficiario' || $_GET['pagina'] == 'salir' || 
										$_GET['pagina'] == 'entradas' || $_GET['pagina'] == 'almacen' || 
										$_GET['pagina'] == 'comites' || $_GET['pagina'] == 'presidentes' || $_GET['pagina'] == 'nuevo-postulante' || 
										$_GET['pagina'] == 'postulantes' || $_GET['pagina'] == 'nuevo-beneficiario' || $_GET['pagina'] == 'beneficiarios' ||
										$_GET['pagina'] == 'socios' || $_GET['pagina'] == 'nueva-entrega' || $_GET['pagina'] == 'lista-entregas'||
										$_GET['pagina'] == 'entregar-productos' || $_GET['pagina'] == 'entregados' || $_GET['pagina'] == 'consultas'
									) {
										include 'paginas/'.$_GET['pagina'].'.php';
										echo '<script type="text/javascript" src="vistas/js/'.$_GET['pagina'].'.js"></script>';
									}else{
										include 'paginas/error.php';
									}
								}else if ($datosUsuario['idTipoUsuario'] == 4) {
									if ($_GET['pagina'] == 'inicio' || 
										$_GET['pagina'] == 'salir' || 
										$_GET['pagina'] == 'nuevo-postulante' || 
										$_GET['pagina'] == 'postulantes' || $_GET['pagina'] == 'nuevo-beneficiario' || $_GET['pagina'] == 'beneficiarios' ||
										$_GET['pagina'] == 'socios' || 
										$_GET['pagina'] == 'consultas'
									) {
										include 'paginas/'.$_GET['pagina'].'.php';
										echo '<script type="text/javascript" src="vistas/js/'.$_GET['pagina'].'.js"></script>';
									}else{
										if ($_GET['pagina'] == 'error') {
											include 'paginas/error.php';
										}
									}
								}
								include "paginas/modulos/footer.php";
							}else{
								include "paginas/modulos/header.php";
								include "paginas/modulos/menu.php";
								include 'paginas/inicio.php';
								echo '<script type="text/javascript" src="vistas/js/inicio.js"></script>';
								include "paginas/modulos/footer.php";
							}
							
						 ?>
					</div>
			<?php

					}
				}
			 ?>
			<script type="text/javascript" src="vistas/js/funciones.js"></script>
		</body>
	<?php endif ?>
</html>