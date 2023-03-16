<?php 
	function mensaje($titulo, $mensaje, $tipo){
		$mensaje = '<script>
			swal({
				title: "'.$titulo.'",
				text: "'.$mensaje.'",
				type: "'.$tipo.'",
				showConfirmButton: true,
				confirmButtonText: "¡Aceptar!"
			}).then(function(result){
				if(result.value){
					history.back();
				}
			});
		</script>';
		return $mensaje;
	}

	function mensajeRecarga($titulo, $mensaje, $tipo){
		$mensaje = '<script>
			swal({
				title: "'.$titulo.'",
				text: "'.$mensaje.'",
				type: "'.$tipo.'",
				showConfirmButton: true,
				confirmButtonText: "¡Aceptar!"
			});
		</script>';
		return $mensaje;
	}

	function mensajeImprimir($titulo, $mensaje, $tipo, $idPostulante,$idInscripcion){
		//window.location="https://www.tupvl.com/sistema/nuevo-postulante";
		$mensaje = '<script>
			swal({
				title: "'.$titulo.'",
				text: "'.$mensaje.'",
				type: "'.$tipo.'",
				showConfirmButton: true,
				confirmButtonText: "¡Imprimir!",
				showCancelButton: true,
				cancelButtonText: "¡Salir!"
			}).then(function(result){
				if(result.value){
					generarPDF('.$idPostulante.', '.$idInscripcion.')
					window.location="http://localhost/tupvl/sistema/nuevo-postulante";			
				}else{
					window.location="http://localhost/tupvl/sistema/nuevo-postulante";
				}
			});
		</script>';
		return $mensaje;
	}

	function validarFecha($fecha){
		$valores = explode('-', $fecha);
		if(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0])){
			return true;
	    }
		return false;
	}

	function compararFechas($fecha1, $fecha2){
		if ($fecha2 <= $fecha1) {
			$respuesta = true;
		}
		else {
			$respuesta = false;
		}
		return $respuesta;
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
			$tiempo = $edad->y.' años';
		}else if($edad->y == 0 && $edad->d == 0){
			$tiempo = $edad->d.' meses';
		}else if($edad->y == 0 && $edad->m == 0){
			$tiempo = $edad->d.' días';
		}else if ($edad->d == 0) {
			$tiempo = $edad->y.' años '.$edad->m.' meses';
		}else if($edad->m == 0){
			$tiempo = $edad->y.' años '.$edad->d.' días';
		}else if ($edad->y == 0) {
			$tiempo = $edad->m.' meses '.$edad->d.' días';
		}else{
			$tiempo = $edad->y.' años '.$edad->m.' meses '.$edad->d.' días';
		}
		return $tiempo;
	}

	function calcularMeses($fechaNacimiento){
		$fecha_nacimiento = new DateTime($fechaNacimiento);
		$hoy = new DateTime();
		$edad = $hoy->diff($fecha_nacimiento);
		$meses = $edad->m;
		$year = $edad->y;
		$edadMeses = ($year * 12) + $meses;
		return $edadMeses;
	}

	function calcularTiempo($meses, $dias){
		$fecha_actual = date("Y-m-d");
		$fechaRestada = '';
		if ($dias == 0) {
			$fechaRestada = date("Y-m-d",strtotime($fecha_actual."- ".$meses." month")); 
		}else if( $meses == 0){
			$fechaRestada = date("Y-m-d",strtotime($fecha_actual."- ".$dias." days")); 
		}else{
			$fechaRestada = date("Y-m-d",strtotime($fecha_actual."- ".$dias." days")); 
			$fechaRestada = date("Y-m-d",strtotime($fechaRestada."- ".$meses." month")); 
		}
		return $fechaRestada;		 
	}

	function calcularFechaVencimiento($fechaInicio, $meses){
		$fecha = date_create($fechaInicio);
		date_add($fecha, date_interval_create_from_date_string($meses." months"));
		return date_format($fecha,"Y-m-d");
	}
 
	function calcularVencimiento($fechaActual, $fehcaVencimiento){
		$tiempo = '';
		$fechv = strtotime($fehcaVencimiento);
		$fecha = strtotime($fechaActual);
		if ($fecha <= $fechv) {
			$fechaVen = new DateTime($fehcaVencimiento);
			$fechaActual = new DateTime($fechaActual);
			$edad = $fechaActual->diff($fechaVen);
			$dias = $edad->d;
			$meses = $edad->m;
			$year = $edad->y;
			if ($edad->m == 0 && $edad->d == 0 && $edad->d == 0) {
				$tiempo = '0 días';
			}else if ($edad->m == 0 && $edad->d == 0) {
				$tiempo = $edad->y.' años';
			}else if($edad->y == 0 && $edad->d == 0){
				$tiempo = $edad->m.' meses';
			}else if($edad->y == 0 && $edad->m == 0){
				$tiempo = $edad->d.' días';
			}else if ($edad->d == 0) {
				$tiempo = $edad->y.' años '.$edad->m.' meses';
			}else if($edad->m == 0){
				$tiempo = $edad->y.' años '.$edad->d.' días';
			}else if ($edad->y == 0) {
				$tiempo = $edad->m.' meses '.$edad->d.' días';
			}else{
				$tiempo = $edad->y.' años '.$edad->m.' meses '.$edad->d.' días';
			}
		}else{
			$tiempo = 'Vencido';	
		}
		return $tiempo;
	}

	function rangoPeriodo($mesActual, $periodo){
		$mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$meses = 12 / $periodo;
		$respuesta = '';
		switch ($meses) {
		    case 2:
		        if ($mesActual >= 1 && $mesActual <=6) {
		        	$respuesta = $mes[6].' - '.$mes[11];	
		        }else{
		        	$respuesta = $mes[0].' - '.$mes[5];	
		        }
		        break;
		    case 3:
		        if ($mesActual >= 1 && $mesActual <=4) {
		        	$respuesta = $mes[4].' - '.$mes[7];	
		        }else if ($mesActual >= 5 && $mesActual <= 8) {
		        	$respuesta = $mes[8].' - '.$mes[11];	
		        }else{
		        	$respuesta = $mes[0].' - '.$mes[3];	
		        }
		        break;
		    case 4:
		        if ($mesActual >= 1 && $mesActual <=3) {
		        	$respuesta = $mes[3].' - '.$mes[5];	
		        }else if ($mesActual >= 4 && $mesActual <= 6) {
		        	$respuesta = $mes[6].' - '.$mes[8];	
		        }else if($mesActual >= 7 && $mesActual <= 9) {
		        	$respuesta = $mes[9].' - '.$mes[11];
		        }else{
		        	$respuesta = $mes[0].' - '.$mes[2];	
		        }
		        break;
	        case 6:
		        if ($mesActual >= 1 && $mesActual <=2) {
		        	$respuesta = $mes[2].' - '.$mes[3];	
		        }else if ($mesActual >= 3 && $mesActual <= 4) {
		        	$respuesta = $mes[4].' - '.$mes[5];	
		        }else if($mesActual >= 5 && $mesActual <= 6) {
		        	$respuesta = $mes[6].' - '.$mes[7];
		        }else if($mesActual >= 7 && $mesActual <= 8){
		        	$respuesta = $mes[8].' - '.$mes[9];	
		        }else if($mesActual >= 9 && $mesActual <=10){
		        	$respuesta = $mes[10].' - '.$mes[11];	
		        }else{
		        	$respuesta = $mes[0].' - '.$mes[1];	
		        }
	        	break;
	        case 12:
		        $respuesta = $mes[$mesActual];
		        break;
	        default:
       			$respuesta = "Error";
		}
		return $respuesta;
	}

	function mesesPeriodo($periodo){
		$mes = array(
			array('id'=>1,'mes'=>"Enero", "estado"=> 'false'),
			array('id'=>2,'mes'=>"Febrero", "estado"=> 'false'), 
			array('id'=>3,'mes'=>"Marzo", "estado"=> 'false'), 
			array('id'=>4,'mes'=>"Abril", "estado"=> 'false'), 
			array('id'=>5,'mes'=>"Mayo", "estado"=> 'false'), 
			array('id'=>6,'mes'=>"Junio", "estado"=> 'false'), 
			array('id'=>7,'mes'=>"Julio", "estado"=> 'false'), 
			array('id'=>8,'mes'=>"Agosto", "estado"=> 'false'), 
			array('id'=>9,'mes'=>"Septiembre", "estado"=> 'false'), 
			array('id'=>10,'mes'=>"Octubre", "estado"=> 'false'), 
			array('id'=>11,'mes'=>"Noviembre", "estado"=> 'false'), 
			array('id'=>12,'mes'=>"Diciembre", "estado"=> 'false')
		);
		if (!empty($periodo)) {
			foreach ($periodo as $key => $value) {
				foreach ($mes as $key => $valMes) {
					if ($value['mesEntrega'] == $valMes['id'] ) {
						$mes[$key]['estado'] = 'true';
						break;
					}
				}
			}
		}
		return $mes;
	}
 ?>