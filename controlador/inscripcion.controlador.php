<?php
	Class ControladorInscripcion{
		/*----------  Mostrar Departamento  ----------*/
		static public function ctrMostrarDepartamento(){
			$respuesta = ModeloInscripcion::mdlMostrarDepartamento();
			return $respuesta;
		}
		/*----------  Mostrar Provincias por departamento  ----------*/
		static public function ctrMostrarProvincias($idDepartamento){
			$respuesta = ModeloInscripcion::mdlMostrarProvincias($idDepartamento);
			return $respuesta;	
		}
		/*----------  Mostrar Distrito por Provincias  ----------*/
		static public function ctrMostrarDistritos($idProvincia){
			$respuesta = ModeloInscripcion::mdlMostrarDistritos($idProvincia);
			return $respuesta;	
		}
		/*----------  Registrar inscripcion de responsable  ----------*/
		static public function ctrRegistrarResponsable($dniResponsable, $apellidoPaterno, $apellidoMaterno, $nombres, $celularResponsable, $correoResponsable){
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoPaterno) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoMaterno) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nombres) && 
				preg_match('/^[0-9]+$/', $dniResponsable) && preg_match('/^[0-9]+$/', $celularResponsable) && 
				preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $correoResponsable)) {
				$respuesta = ModeloInscripcion::mdlRegistrarResponsable($dniResponsable, $apellidoPaterno, $apellidoMaterno, $nombres, $celularResponsable, $correoResponsable);
				return $respuesta;
			}
		}
		/*----------  Registrar municipalidad  ----------*/
		public function ctrRegistrarMunicipalidad($idDistrito, $nombreMunicipalidad, $ruta, $direccionMunicipalidad, $ruc, $idResponsable){
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $nombreMunicipalidad)) {
				$idDistritoMuni = intval($idDistrito);
				$respuesta = ModeloInscripcion::mdlRegistrarMunicipalidad($idDistritoMuni, $nombreMunicipalidad, $ruta, $direccionMunicipalidad, $ruc, $idResponsable);
				return $respuesta;
			}			
		}
		/*----------  buscar municipalidad  ----------*/
		public function ctrBuscarMunicipalidad($ruc){
			if (preg_match('/^[0-9]+$/', $ruc)) {
				$respuesta = ModeloInscripcion::mdlBuscarMunicipalidad($ruc);
				return $respuesta;
			}				
		}
	}	