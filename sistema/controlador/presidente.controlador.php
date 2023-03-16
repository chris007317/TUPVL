<?php
	Class ControladorPresidente{
		/*----------  Agregar nuevo presidente  ----------*/
		public function ctrAgregarPresidente(){
			if (isset($_POST['idComite']) && isset($_POST['txtDniPresidente']) && 
				isset($_POST['txtApellidoPaterno']) && isset($_POST['txtApellidoMaterno']) && 
				isset($_POST['txtNombrePresidente']) && !empty($_POST['txtApellidoMaterno']) && 
				!empty($_POST['txtNombrePresidente']) && !empty($_POST['txtDniPresidente']) && 
				!empty($_POST['idComite']) && !empty($_POST['txtApellidoPaterno'])) {
				$apellidoPaterno = trim($_POST['txtApellidoPaterno']);
				$apellidoMaterno = trim($_POST['txtApellidoMaterno']);
				$nombres = trim($_POST['txtNombrePresidente']);
				$dni = trim($_POST['txtDniPresidente']);
				$celular = trim($_POST['txtCelularPresidente']);
				$correo = trim($_POST['txtCorreoPresidente']);
				if (validarFecha($_POST['dateFechaPresidente']) && compararFechas(date('Y-m-d'), $_POST['dateFechaPresidente']) &&
					preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoPaterno) &&
					preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoMaterno) &&
					preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nombres) && 
					(preg_match('/^[0-9]+$/', $dni) && preg_match('/^[0-9]+$/', $celular) || empty($celular))&& 
					(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $correo) || empty($correo)) 
				){
					$idComite = intval($_POST['idComite']);
					$fecha = $_POST['dateFechaPresidente'];
					$agregar = new ModeloPersona();
				 	$respuesta = $agregar->mdlRegistrarPersona($nombres, $apellidoMaterno, $apellidoPaterno, $dni);
				 	if ($respuesta > 0) {
				 		$idPersona = $respuesta;
				 		$agregar = new ModeloPresidente();
				 		$respuesta = $agregar->mdlAgregarPresidente($correo, $celular, $fecha, $idPersona, $idComite);
					 	if($respuesta == 'existe'){
				 			echo mensaje('¡ADVERTENCIA!', '¡El presidente ya existe y se encuentra activo en otro comite!', 'warning');
					 	}else if($respuesta > 0) {
		 					if (isset($_POST['idPresidente']) && !empty($_POST['idPresidente'])) {
						 		$agregar = new ModeloPresidente();
						 		$respuesta = $agregar->mdlEditarEstadoPresidente('estadoPresidente', FALSE, $_POST['idPresidente']);
						 		if ($respuesta) {
						 			echo mensaje('¡CORRECTO!', '¡El presidente ha sido cambiado con exito!', 'success');
						 		}else{
						 			echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar al presidente!', 'error');	
						 		}
							}else{
								echo mensaje('¡CORRECTO!', '¡El presidente ha sido registrado con exito!', 'success');
							}
					 	}else{
					 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar al presidente!', 'error');	
					 	}
				 	}else{
				 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de registrar al presidente!', 'error');
				 	}

				}else{
					echo mensaje('CORREGIR!', '¡Verifique que no haya insertado caracteres especiales en los campos!', 'warning');	
				}
			}
		}
		/*----------  mostrar presidente  ----------*/
		static public function ctrMostrarPresidente($item, $valor){
			$respuesta = new ModeloPresidente();
			return $respuesta->mdlMostrarPresidente($item, $valor);
		}
		/*----------  Mostrar presidentes  ----------*/
		static public function ctrMostrarPresidentes($item, $valor, $idMunicipalidad){
			$respuesta = new ModeloPresidente();
			return $respuesta->mdlMostrarPresidentes($item, $valor, $idMunicipalidad);
		}
		/*----------  Agregar nuevo presidente  ----------*/
		public function ctrEditarPresidente(){
			if (isset($_POST['idPresidente']) && !empty($_POST['idPresidente'])) {
				$celular = trim($_POST['txtCelularPresidente']);
				$correo = trim($_POST['txtCorreoPresidente']);
				if (validarFecha($_POST['dateFechaPresidente']) && compararFechas(date('Y-m-d'), $_POST['dateFechaPresidente']) &&
					(preg_match('/^[0-9]+$/', $celular) || empty($celular)) && 
					(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $correo) || empty($correo)) 
				){
					$idPresidente = intval($_POST['idPresidente']);
					$fecha = $_POST['dateFechaPresidente'];
					$agregar = new ModeloPresidente();
				 	$respuesta = $agregar->mdlEditarPresidente($correo, $celular, $fecha, $idPresidente);
				 	if ($respuesta == 'ok') {
						echo mensaje('¡CORRECTO!', '¡Los datos fueron editados con exito!', 'success');
				 	}else{
				 		echo mensaje('¡ERROR!', '¡Ocurrio un error al momento de editar al presidente!', 'error');	
				 	}
				}else{
					echo mensaje('CORREGIR!', '¡Verifique que no haya insertado caracteres especiales en los campos!', 'warning');	
				}
			}
		}

		/*----------  editar estado presidente  ----------*/
		public function ctrCambiarPresidente(){
          	$registrarPresidente = new ControladorPresidente();
  			$registrarPresidente->ctrAgregarPresidente();
		}
		/*----------  contar presidentes  ----------*/
		static public function ctrContarPresidentes($idMunicipalidad){
			$respuesta = new ModeloPresidente();
			return $respuesta->mdlContarPresidentes($idMunicipalidad);
		}
	}