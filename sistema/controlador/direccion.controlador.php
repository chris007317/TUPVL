<?php
	Class ControladorDireccion{
		/*----------  mostrar ciudad  ----------*/
		static public function ctrMostrarCiudadDireccion($idMunicipaliadad){
			$respuesta = new ModeloDireccion();
			return $respuesta->mdlMostrarCiudadDireccion($idMunicipaliadad);
		}
		/*----------  agregar direccion  ----------*/
		static public function ctrAgregarDirección(){
			if (isset($_POST['idPersona']) && isset($_POST['cmbDistritoDir']) && isset($_POST['txtDireccion']) &&
				!empty($_POST['idPersona']) && !empty($_POST['cmbDistritoDir']) && !empty($_POST['txtDireccion'])) {
				$direccion = trim($_POST['txtDireccion']);
				$numero = trim($_POST['txtNumeroDir']);
				$idPersona = intval($_POST['idPersona']);
				$idDistrito = intval($_POST['cmbDistritoDir']);
				if ((preg_match('/^[0-9]+$/', $numero) || empty($numero)) &&
					preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $direccion) &&
					(preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtDescripcionDir"]) || empty($_POST['txtDescripcionDir']))){
					$descripcion = $_POST['txtDescripcionDir'];
					$agregar = new ModeloDireccion();
				 	$respuesta = $agregar->mdlAgregarDireccion($direccion, $numero, $descripcion, $idDistrito);
				 	if($respuesta > 0){
			 			return $respuesta;
				 	}else{
						return 'error';
				 	}
				}else{
					return 'novalido';	
				}
			}
		}
		/*----------  editar direccion  ----------*/
		static public function ctrEditarDireccion(){
			if (isset($_POST['idPersona']) && isset($_POST['cmbDistritoDir']) && isset($_POST['txtDireccion']) && isset($_POST['idDireccion']) &&
				!empty($_POST['idPersona']) && !empty($_POST['cmbDistritoDir']) && !empty($_POST['txtDireccion']) && !empty($_POST['idDireccion'])) {
				$direccion = trim($_POST['txtDireccion']);
				$numero = trim($_POST['txtNumeroDir']);
				$idPersona = intval($_POST['idPersona']);
				$idDistrito = intval($_POST['cmbDistritoDir']);
				$idDireccion = intval($_POST['idDireccion']);
				if ((preg_match('/^[0-9]+$/', $numero) || empty($numero)) &&
					preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $direccion) &&
					(preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["txtDescripcionDir"]) || empty($_POST['txtDescripcionDir']))){
					$descripcion = $_POST['txtDescripcionDir'];
					$agregar = new ModeloDireccion();
				 	$respuesta = $agregar->mdlEditarDireccion($direccion, $numero, $descripcion, $idDistrito, $idDireccion);
				 	return $respuesta;
				}else{
					return 'novalido';	
				}
			}
		}
		/*----------  mostrar departamento  ----------*/
		static public function ctrMostrarDepartamentos(){
			$respuesta = new ModeloDireccion();
			return $respuesta->mdlMostrarDepartamentos();
		}
		/*----------  mostrar provincias  ----------*/
		static public function ctrMostrarProvincias($idDepartamento){
			$respuesta = new ModeloDireccion();
			return $respuesta->mdlMostrarProvincias($idDepartamento);
		}
				/*----------  mostrar departamento  ----------*/
		static public function ctrMostrarDistritos($idProvincia){
			$respuesta = new ModeloDireccion();
			return $respuesta->mdlMostrarDistritos($idProvincia);
		}
		/*----------  mostrar direccion  ----------*/
		static public function ctrMostrarDireccion($idDireccion){
			$respuesta = new ModeloDireccion();
			return $respuesta->mdlMostrarDireccion($idDireccion);	
		}
	}