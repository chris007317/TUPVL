<?php 
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'enviarCorreo') {
		$nombrePersona = $_POST['txtNombreMensaje'];
		$correoPersona = $_POST['txtCorreoMensaje'];
		$asuntoPersona = $_POST['txtAsunto'];
		$mensajePersona = $_POST['txtMensaje'];

		$header = 'From: ' . $correoPersona . " \r\n";
		$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
		$header .= "Mime-Version: 1.0 \r\n";
		$header .= "Content-Type: text/plain";

		$para = 'soporte@tupvl.com';
		mail($para, $asuntoPersona, $mensajePersona, $header);
		echo 'ok';
		return;
	}

 ?>