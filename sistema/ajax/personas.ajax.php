<?php 
	require_once '../controlador/personas.controlador.php';
	require_once '../modelo/persona.modelo.php';

	require_once '../controlador/direccion.controlador.php';
	require_once '../modelo/direccion.modelo.php';

	require_once '../controlador/beneficiario.controlador.php';
	require_once '../modelo/beneficiario.modelo.php';

	require_once '../controlador/socio.controlador.php';
	require_once '../modelo/socio.modelo.php';

	require_once '../controlador/postulante.controlador.php';
	require_once '../modelo/postulante.modelo.php';

	require_once '../controlador/inscripcion.controlador.php';
	require_once '../modelo/inscripcion.modelo.php';
	session_start();

	Class AjaxPersona{
		/*----------  mostrar personas  ----------*/
		public function ajaxMostrarPersona($dni){
			$item = 'dniPersona';
			$respuesta = ControladorPersona::ctrMostrarPersona($item, $dni);
			if (!empty($respuesta)) {
				return($respuesta);
			}else{
				$response = '{"valor":"vacio"}';
				return $response;
				/* 
					$apiKey = 'f8d003afd09f7330510df25b26382a59961dcea2';
			      	$url = 'https://dni.optimizeperu.com/api/prod/persons/'.$dni;
			      	$curl = curl_init();
			      	try{
			    	  	curl_setopt_array($curl, array(
				        CURLOPT_URL => $url,
				        CURLOPT_RETURNTRANSFER => true,
				        CURLOPT_ENCODING => '',
				        CURLOPT_MAXREDIRS => 10,
				        CURLOPT_TIMEOUT => 0,
				        CURLOPT_FOLLOWLOCATION => true,
				        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				        CURLOPT_CUSTOMREQUEST => 'GET',
				        CURLOPT_HTTPHEADER => array(
					          'Authorization: Token '.$apiKey,
					          'Accept: application/json'
				        	),
				      	));
				      
				      	$response = curl_exec($curl);
				      	$respuesta = json_decode($response, true);
				      	curl_close($curl);
				      		//echo $respuesta['name'];
				      	if (empty($respuesta)) {
				      		$datos = '{"valor":"vacio"}';
				      		return $datos;
				      	}else if(isset($respuesta['name']) && $respuesta['name'] == '_'){
				      		return 'error';
				      	}else if($respuesta['detail'] == 'Usuario inactivo o borrado.'){
				      	    $datos = '{"valor":"vacio"}';
				      		return $datos;
				      	}
				      	return $response;
			      	}catch(Exception $e){
						return('error');
					} 
				 */
				 
			      	
				  
				/*----------  

					try{
					    //$consultaRuc = @file_get_contents("https://dniruc.apisperu.com/api/v1/ruc/".$rucProveedor."?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImNyaXN0aWFuMDA3MzE3QGdtYWlsLmNvbSJ9.CmuHB-VHrneCxpiWEc7zA2WFys_CuB-IiQ_FRK7OE-g");
					    $consultaDni = @file_get_contents("https://dni.optimizeperu.com/api/persons/".$dni."?format=json");
					    if ($consultaDni === false) {
					    	 throw new Exception('error');
					    }else if($consultaDni == '{}'){
					    	return('{"valor":"vacio"}');
					    }else{
						    return($consultaDni);
					    }
					}catch(Exception $e){
						return($e->getMessage()); 
					}



				  ----------*/
				

			}
		}
		/*----------  Mostrar persona por id  ----------*/
		public function ajaxMostrarPersonaId($idPersona){
			$item = 'idPersona';
			$respuesta = ControladorPersona::ctrMostrarPersona($item, $idPersona);
			echo json_encode($respuesta);
		}

		/*----------  Mostrar persona por id  ----------*/
		public function ajaxVerPostulanteId($idPersona){
			$respuesta = '';
			$datos = '';
			$idDireccion = null;
			$beneficiario = ControladorBeneficiario::ctrMostrarBeneficiario('idPersonaPostulante', $idPersona);
			if (!empty($beneficiario)) {
				$respuesta = '{"valor":"existe"}';
			}else{
				$postulante = ControladorPostulante::ctrMostrarPostulante('idPersonaPostulante', $idPersona);
				if (!empty($postulante)) {
					$idDireccion = $postulante['idDireccion'];
					$datos = $postulante;
				}else{
					$persona = ControladorPersona::ctrMostrarPersona('idPersona', $idPersona);
					$idDireccion = $persona['idDireccion'];
					$datos = $persona;
				}
				if ($idDireccion != null) {
					$direccion = ControladorDireccion::ctrMostrarDireccion($datos['idDireccion']); 
					$respuesta = array_merge($datos, $direccion);
				}else{
					$respuesta = array_merge($datos);
				}
			}
			echo json_encode($respuesta);
		}

		/*----------  Mostrar persona por id  ----------*/
		public function ajaxVerPostulanteDni($dni){
			$respuesta = '';
			$datos = '';
			$idDireccion = null;
			$beneficiario = ControladorBeneficiario::ctrMostrarBeneficiario('dniPersona', $dni);
			if (!empty($beneficiario)) {
				$respuesta = '{"valor":"existe"}';
			}else{
				$postulante = ControladorPostulante::ctrMostrarPostulante('dniPersona', $dni);
				if (!empty($postulante)) {
					$idDireccion = $postulante['idDireccion'];
					$datos = $postulante;
				}else{
					$persona = ControladorPersona::ctrMostrarPersona('dniPersona', $dni);
					if (!empty($persona)) {
						$idDireccion = $persona['idDireccion'];
						$datos = $persona;
					}else{
						$datos = '{"valor":"vacio"}';
						/* 
							
							$apiKey = 'f8d003afd09f7330510df25b26382a59961dcea2';
					      	$url = 'https://dni.optimizeperu.com/api/prod/persons/'.$dni;
					      	$curl = curl_init();
							try{
					    	  	curl_setopt_array($curl, array(
						        CURLOPT_URL => $url,
						        CURLOPT_RETURNTRANSFER => true,
						        CURLOPT_ENCODING => '',
						        CURLOPT_MAXREDIRS => 10,
						        CURLOPT_TIMEOUT => 0,
						        CURLOPT_FOLLOWLOCATION => true,
						        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						        CURLOPT_CUSTOMREQUEST => 'GET',
						        CURLOPT_HTTPHEADER => array(
							          'Authorization: Token '.$apiKey,
							          'Accept: application/json'
						        	),
						      	));
						      
						      	$response = curl_exec($curl);
						      	$respuesta = json_decode($response, true);
						      	curl_close($curl);
						      		//echo $respuesta['name'];
						      	if (empty($respuesta)) {
						      		$datos = '{"valor":"vacio"}';
						      		
						      	}else if($respuesta['name'] == '_'){
						      		$datos = 'error';
						      	}else if($respuesta['detail'] == 'Usuario inactivo o borrado.'){
	        			      	    $datos = '{"valor":"vacio"}';
	        			      	}else{
						      		$datos = $response;
						      	}
						      	


						 */


							/*----------  

						    $consultaDni = @file_get_contents("https://dni.optimizeperu.com/api/persons/".$dni."?format=json");
						    if ($consultaDni === false) {
							    	 throw new Exception("error");
						    }else if($consultaDni == '{}'){
							    	$datos = '{"valor":"vacio"}';
						    }else{
						    	$datos = $consultaDni;
						    }


						}catch(Exception $e){
							$datos = $e->getMessage();
						}
							  ----------*/
							
					}
				}
				if ($idDireccion != null) {
					$direccion = ControladorDireccion::ctrMostrarDireccion($datos['idDireccion']);
					$respuesta = array_merge($datos, $direccion);
				}else{
					$respuesta = $datos;
				}
			}
			echo json_encode($respuesta);
		}

		/*----------  Mostrar persona por id  ----------*/
		public function ajaxVerSocioDni($dniSocio, $idMunicipalidad){
			$respuesta = '';
			$datos = '';
			$idDireccion = null;
			$verSocio = ControladorSocio::ctrMostrarSocio('dniPersona', $dniSocio, $idMunicipalidad);
				if (!empty($verSocio)) {
					$idDireccion = $verSocio['idDireccion'];
					$datos = $verSocio;
				}else{
					$persona = ControladorPersona::ctrMostrarPersona('dniPersona', $dniSocio);
					if (!empty($persona)) {
						$idDireccion = $persona['idDireccion'];
						$datos = $persona;
					}else{
						$datos = '{"valor":"vacio"}';
						/* 
							$apiKey = 'f8d003afd09f7330510df25b26382a59961dcea2';
					      	$url = 'https://dni.optimizeperu.com/api/prod/persons/'.$dni;
					      	$curl = curl_init();
							try{

					    	  	curl_setopt_array($curl, array(
						        CURLOPT_URL => $url,
						        CURLOPT_RETURNTRANSFER => true,
						        CURLOPT_ENCODING => '',
						        CURLOPT_MAXREDIRS => 10,
						        CURLOPT_TIMEOUT => 0,
						        CURLOPT_FOLLOWLOCATION => true,
						        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						        CURLOPT_CUSTOMREQUEST => 'GET',
						        CURLOPT_HTTPHEADER => array(
							          'Authorization: Token '.$apiKey,
							          'Accept: application/json'
						        	),
						      	));
						      
						      	$response = curl_exec($curl);
						      	$respuesta = json_decode($response, true);
						      	curl_close($curl);
						      		//echo $respuesta['name'];
						      	if (empty($respuesta)) {
						      		$datos = '{"valor":"vacio"}';
						      		
						      	}else if($respuesta['name'] == '_'){
						      		$datos = 'error';
						      	}else if($respuesta['detail'] == 'Usuario inactivo o borrado.'){
	        			      	    $datos = '{"valor":"vacio"}';
	        			      	}else{
						      		$datos = $response;
						      	}

						 */
						

							/*----------  
							    $consultaDni = @file_get_contents("https://dni.optimizeperu.com/api/persons/".$dniSocio."?format=json");
							    if ($consultaDni === false) {
								    	 throw new Exception('error');
								    }else if($consultaDni == '{}' || $consultaDni == ''){
								    	$datos = '{"valor":"vacio"}';
							    }else{
							    	$datos = $consultaDni;
							    }



						}catch(Exception $e){
							$datos = $e->getMessage();
						}
							  ----------*/
							
					}
				}
				if ($idDireccion != null) {
					$direccion = ControladorDireccion::ctrMostrarDireccion($datos['idDireccion']);
					$respuesta = array_merge($datos, $direccion);
				}else{
					$respuesta = $datos;
				}
			echo json_encode($respuesta);
		}
		/*----------  mostrar inscripción de un postulante  ----------*/
		public function ajaxVerInscripcionPostulante($idInscripcion){
			$inscripcion = ControladorInscripcion::ctrMostrarInscripcion('idInscripcion', $idInscripcion);
			$postulante = ControladorPostulante::ctrMostrarPostulante('idPostulante', $inscripcion['idPostulante']);
			$respuesta = array_merge($inscripcion, $postulante);
			$edad = array("edadPostulante" => calcularEdad($postulante['fechaNacimiento']));
			$datos = array_merge($respuesta, $edad);
			echo json_encode($datos);
		}
		
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDni') {
		$dni = $_POST['dni'];
		$persona = new AjaxPersona();
		$respuesta = $persona->ajaxMostrarPersona($dni);
		echo json_encode($respuesta);
	}
 
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarId') {
		$idPersona = $_POST['idPersona'];
		$persona = new AjaxPersona();
		$persona->ajaxMostrarPersonaId($idPersona);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDniDir') {
		$dni = $_POST['dni'];
		$persona = new AjaxPersona();
		$respuesta = $persona->ajaxMostrarPersona($dni);
		if (isset($respuesta['idDireccion']) && $respuesta['idDireccion'] != null) {
			$direccion = ControladorDireccion::ctrMostrarDireccion($respuesta['idDireccion']);
			$datos = array_merge($respuesta, $direccion);
			echo json_encode($datos);
		}else{
			echo json_encode($respuesta);
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarIdDir') {
		$idPersona = $_POST['idPersona'];
		$persona = new AjaxPersona();
		$persona->ajaxVerPostulanteId($idPersona);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'calcularFecha') {
		$fechaNacimiento = $_POST['fechaNacimiento'];
		$fechaActual = date('Y-m-d');
		if ($fechaNacimiento > 1900 || $fechaNacimiento <= $fechaActual) {
			$fecha_nacimiento = new DateTime($fechaNacimiento);
			$hoy = new DateTime();
			$edad = $hoy->diff($fecha_nacimiento);
			echo json_encode($edad);
		}else{
			echo "error";
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDniPostulante') {
		$dni = $_POST['dni'];
		$persona = new AjaxPersona();
		$persona->ajaxVerPostulanteDni($dni);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarPostulanteInscripcion') {
		$idInscripcion = $_POST['idInscripcion'];
		$persona = new AjaxPersona();
		$persona->ajaxVerInscripcionPostulante($idInscripcion);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDniSocio') {
		$idMunicipalidad = $_SESSION['idMunicipalidadPvl'];
		$dniSocio = $_POST['dniSocio'];
		$persona = new AjaxPersona();
		$persona->ajaxVerSocioDni($dniSocio, $idMunicipalidad);
	}


	function calcularEdad($fechaNacimiento){
		$fechaActual = date('Y-m-d');
			$fecha_nacimiento = new DateTime($fechaNacimiento);
			$hoy = new DateTime();
			$edad = $hoy->diff($fecha_nacimiento);
			$dias = $edad->d;
			$meses = $edad->m;
			$year = $edad->y;
			$tiempo = '';
			if ($edad->m == 0 && $edad->d == 0) {
				$tiempo = $edad->y.'años';
			}else if ($edad->d == 0) {
				$tiempo = $edad->y.' años '.$edad->m.' meses';
			}else if($edad->m == 0){
				$tiempo = $edad->y.' años '.$edad->d.' días';
			}else{
				$tiempo = $edad->y.' años '.$edad->m.' meses '.$edad->d.' días';
			}
			return $tiempo;
	}
 ?>