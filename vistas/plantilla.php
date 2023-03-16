<?php
	$ruta = ControladorRuta::ctrRuta();
	$servidor = ControladorRuta::ctrServidor();
?>
<!DOCTYPE html>
<html lang="es">
<?php 
	if (isset($_GET['pagina'])) {
			if($_GET['pagina'] == "inscripcion"){
				include "paginas/inscripcion.php";
			}else{ 
				echo '<script>
					window.location = "'.$ruta.'";
				</script>';
			}

		}else{ 
			include "paginas/inicio.php";
		}
 ?>
</html>