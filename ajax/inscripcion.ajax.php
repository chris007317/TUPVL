<?php 
	require_once "../controlador/inscripcion.controlador.php";
	require_once "../modelo/inscripcion.modelo.php";
	class AjaxInscripcion{
		/*----------  Mostrar provincias por departamentos  ----------*/
		public function ajaxMostrarProvincias($idDepartamento){
			$valor = $idDepartamento;
			$respuesta = ControladorInscripcion::ctrMostrarProvincias($valor);
			echo json_encode($respuesta);
		}
		/*----------  Mostrar distritos por provincias  ----------*/
		public function ajaxMostrarDistritos($idProvincia){
			$valor = $idProvincia;
			$respuesta = ControladorInscripcion::ctrMostrarDistritos($valor);
			echo json_encode($respuesta);
		}
		/*----------  Registrar Responsable  ----------*/
		public function ajaxRegistrarResponsable($dniResponsable, $apellidoPaterno, $apellidoMaterno, $nombres, $celularResponsable, $correoResponsable){
			$respuesta = ControladorInscripcion::ctrRegistrarResponsable($dniResponsable, $apellidoPaterno, $apellidoMaterno, $nombres, $celularResponsable, $correoResponsable);
			return $respuesta;
		}
		/*----------  Registrar Municipalidad  ----------*/
		public function ajaxRegistrarMunicipalidad($idDistrito, $nombreMunicipalidad, $ruta, $direccionMunicipalidad, $ruc, $idResponsable){
			$respuesta = ControladorInscripcion::ctrRegistrarMunicipalidad($idDistrito, $nombreMunicipalidad, $ruta, $direccionMunicipalidad, $ruc, $idResponsable);
			echo $respuesta;
		}
		/*----------  buscar municipalidad  ----------*/
		public function ajaxBuscarMunicipalidad($ruc){
			$respuesta = ControladorInscripcion::ctrBuscarMunicipalidad($ruc);
			return $respuesta;
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarProvincias') {
		$provincias = new AjaxInscripcion();
		$idDepartamento = $_POST['idDepartamento'];
		$provincias->ajaxMostrarProvincias($idDepartamento);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarDistritos') {
		$distritos = new AjaxInscripcion();
		$idProvincia = $_POST['idProvincia'];
		$distritos->ajaxMostrarDistritos($idProvincia);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDni') {
		$dni = $_POST['dni'];
		try{
		    //$consultaDni = @file_get_contents("https://dniruc.apisperu.com/api/v1/dni/".$dni."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNyaXN0aWFuMDA3MzE3QGdtYWlsLmNvbSJ9.CmuHB-VHrneCxpiWEc7zA2WFys_CuB-IiQ_FRK7OE-g");
		    $consultaDni = @file_get_contents("https://dni.optimizeperu.com/api/persons/".$dni."?format=json");
		    if ($consultaDni === false) {
		    	 throw new Exception('error');
		    }else{
			    echo json_encode($consultaDni);
		    }
		}catch(Exception $e){
			echo json_encode($e->getMessage());
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'registrarInscripcion') {
		if (!empty($_POST['cmbDistritos']) && !empty($_POST['txtNombreMunicipalidad']) && !empty($_POST['txtDireccionMunicipalidad']) && !empty($_POST['txtDniResponsable']) && !empty($_POST['txtCorreoResponsable']) && !empty($_POST['txtCelularResponsable']) && !empty($_POST['txtApellidoPaterno']) && !empty($_POST['txtApellidoMaterno']) && !empty($_POST['txtNombres']) && !empty($_POST['txtRuc'])) {
			$idDistrito = $_POST['cmbDistritos'];
			$nombreMunicipalidad = $_POST['txtNombreMunicipalidad'];
			$direccionMunicipalidad = $_POST['txtDireccionMunicipalidad'];
			$dniResponsable = $_POST['txtDniResponsable'];
			$correoResponsable = $_POST['txtCorreoResponsable'];
			$celularResponsable = $_POST['txtCelularResponsable'];
			$apellidoMaterno = $_POST['txtApellidoMaterno'];
			$apellidoPaterno = $_POST['txtApellidoPaterno'];
			$nombres = $_POST['txtNombres'];
			$ruc = $_POST['txtRuc'];
			$inscripcion = new AjaxInscripcion();
			$muni = $inscripcion->ajaxBuscarMunicipalidad($ruc);
			if ($muni) {
				echo "existe";
			}else{
				if (strlen($dniResponsable) == 8 && strlen($celularResponsable) == 9) {
					$respuesta = $inscripcion->ajaxRegistrarResponsable($dniResponsable, $apellidoPaterno, $apellidoMaterno, $nombres, $celularResponsable, $correoResponsable);
					if ($respuesta == 'existe') {
						echo "existe";
					}else if ($respuesta == 0) {
						echo "error";
					}else{
						$idResponsable = $respuesta;
						$ruta = '';
					   	if (isset($_FILES['logoMunicipalidad']['tmp_name']) && !empty($_FILES['logoMunicipalidad']['tmp_name'])) {
					   		list($ancho, $alto) = getimagesize($_FILES['logoMunicipalidad']['tmp_name']);
		   					$nuevoAncho = 480;
							$nuevoAlto = 382;
							$directorio = "../sistema/vistas/img/municipalidades";
							if ($_FILES['logoMunicipalidad']['type'] == "image/jpeg") {
								$nombreImg = uniqid().'-'.str_replace(" ", "-", $nombreMunicipalidad);
								$ruta = $directorio."/".$nombreImg.".jpg";
								$origen = imagecreatefromjpeg($_FILES['logoMunicipalidad']['tmp_name']);
								$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
								imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
								imagejpeg($destino, $ruta);
								$ruta = 'img/municipalidades/'.$nombreImg.'.jpg';

							}else if($_FILES['logoMunicipalidad']['type'] == "image/png"){
								$nombreImg = uniqid().'-'.str_replace(" ", "-", $nombreMunicipalidad);
								$ruta = $directorio."/".$nombreImg.".png";
								$origen = imagecreatefrompng($_FILES['logoMunicipalidad']['tmp_name']);
								$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
								imagealphablending($destino, FALSE);
								imagesavealpha($destino, TRUE);
								imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
								imagepng($destino, $ruta);
								$ruta = 'img/municipalidades/'.$nombreImg.'.png';
							}else{
								echo "error";
								return;
							}
					   	}else{
					   		$ruta = 'img/municipalidades/municipalidad.png';
					   	}
					   	$inscripcion->ajaxRegistrarMunicipalidad($idDistrito, $nombreMunicipalidad, $ruta, $direccionMunicipalidad, $ruc, $idResponsable);
					}
				}else{
					echo "error1";
				}
			}
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarRuc') {
		$rucMunicipalidad = $_POST['ruc'];
				$rucMunicipalidad = $_POST['ruc'];
		   	   $apiKey = 'RyWq72L4Va9brz3ccsaHqWJy04Y6YjjAAU4wJOm9xhRFZMNgDGX8B9qRmmfH';
	      $url = 'https://api.peruapis.com/v1/ruc';
	      
	      $curl = curl_init();
	      
	      curl_setopt_array($curl, array(
	        CURLOPT_URL => $url,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_ENCODING => '',
	        CURLOPT_MAXREDIRS => 10,
	        CURLOPT_TIMEOUT => 0,
	        CURLOPT_FOLLOWLOCATION => true,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => 'POST',
	        CURLOPT_POSTFIELDS => array('document' => $rucMunicipalidad),
	        CURLOPT_HTTPHEADER => array(
	          'Authorization: Bearer '.$apiKey,
	          'Accept: application/json'
	        ),
	      ));
	      
	      $response = curl_exec($curl);
	      curl_close($curl);
	      
	      
	      echo $response;
		/*------
				try{
		    //$consultaRuc = @file_get_contents("https://dniruc.apisperu.com/api/v1/ruc/".$rucMunicipalidad."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNyaXN0aWFuMDA3MzE3QGdtYWlsLmNvbSJ9.CmuHB-VHrneCxpiWEc7zA2WFys_CuB-IiQ_FRK7OE-g");
		    $consultaRuc = @file_get_contents("https://dni.optimizeperu.com/api/company/".$rucMunicipalidad."?format=json");
		    if ($consultaRuc === false) {
		    	 throw new Exception('error');
		    }else{
			    echo json_encode($consultaRuc);
		    }
		}catch(Exception $e){
			echo json_encode($e->getMessage());
		}
		------*/

	}
 ?>