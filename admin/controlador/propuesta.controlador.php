<?php
	Class ControladorPropuesta{
		/*----------  Mostrar propuestas  ----------*/
		static public function ctrMostrarPropuestas(){
			$propuestas = new ModeloPropuesta();
			return $propuestas->mdlMostrarPropuestas();
		} 
		static public function ctrBuscarPropuestas($buscar){
			$propuestas = new ModeloPropuesta();
			return $propuestas->mdlBuscarPropuestas($buscar);	
		}
		/*----------  mostrar Regiones  ----------*/
		static public function ctrMostrarRegion($idDistrito){
			$region = new ModeloPropuesta();
			return $region->mdlMostrarRegion($idDistrito);
		}
		/*----------  rechazar propuesta  ----------*/
		static public function ctrEditarPropuesta($item, $valor, $idPropuesta){
			$propuesta = new ModeloPropuesta();
			return $propuesta->mdlEditarPropuesta($item, $valor, $idPropuesta);	
		}
		/*----------  buscar propuesta  ----------*/
		static public function ctrBuscarPropuesta($item, $valor){
			$propuesta = new ModeloPropuesta();
			return $propuesta->mdlBuscarPropuesta($item, $valor);	
		}
		/*----------  insertar municipalidad  ----------*/
		static public function ctrRegistrarMunicipalidad($nombreMuni, $imagenMuni, $direccionMuni, $ruc, $idDistrito){
			$respuesta = new ModeloPropuesta();
			return $respuesta->mdlRegistrarMunicipalidad($nombreMuni, $imagenMuni, $direccionMuni, $ruc, $idDistrito);
		}
		/*----------  insertar persona  ----------*/
		static public function ctrRegistrarPersona($nombrePersona, $apellidoMaterno, $apellidoPaterno, $dni){
			$respuesta = new ModeloPropuesta();
			return $respuesta->mdlRegistrarPersona($nombrePersona, $apellidoMaterno, $apellidoPaterno, $dni);
		}
		/*----------  Buscar persona  ----------*/
		static public function ctrBuscarPersona($item, $valor){
			$respuesta = new ModeloPropuesta();
			return $respuesta->mdlBuscarPersona($item, $valor);
		}	
		/*----------  Registrar usuario  ----------*/
		static public function ctrRegistrarUsuario($usuario, $contra, $correo, $celular, $idPersona, $tipoUsuario, $idMunicipalidad){
			$respuesta = new ModeloPropuesta();
			return $respuesta->mdlRegistrarUsuario($usuario, $contra, $correo, $celular, $idPersona, $tipoUsuario, $idMunicipalidad);
		}
	}