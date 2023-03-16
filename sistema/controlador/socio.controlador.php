<?php 
	Class ControladorSocio{
		/*----------  Mostrar un socio  ----------*/
		static public function ctrMostrarSocio($item, $valor, $idMunicipalidad){
			$respuesta = new ModeloSocio();
			return $respuesta->mdlMostrarSocio($item, $valor, $idMunicipalidad);
		}
		/*----------  agregar socio  ----------*/
		static public function ctrAgregarSocio($correo, $celular, $idPersona, $idMunicipalidad){
			$respuesta = new ModeloSocio();
			return $respuesta->mdlAgregarSocio($correo, $celular, $idPersona, $idMunicipalidad);
		}
		/*----------  Mostrar socios  ----------*/
		static public function ctrMostrarSocios($idMunicipalidad){
			$respuesta = new ModeloSocio();
			return $respuesta->mdlMostrarSocios($idMunicipalidad);
		}
		/*----------  Mostrar socios  ----------*/
		static public function ctrMostrarTipoSocios(){
			$respuesta = new ModeloSocio();
			return $respuesta->mdlMostrarTiposSocios();
		}
		/*----------  Listar socios  ----------*/
		static public function ctrListarSocios($idMunicipalidad, $estado){
			$respuesta = new ModeloSocio();
			return $respuesta->mdlListarSocios($idMunicipalidad, $estado);
		}

		static public function ctrEditarSocioDatos(){
			if (!empty($_POST['idSocio']) && (preg_match('/^[0-9]+$/', $_POST['txtCelularSocio']) || empty($_POST['txtCelularSocio'])) && 
				(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['txtCorreoSocio']) || empty($_POST['txtCorreoSocio'])) 
			){
				$correo = $_POST['txtCorreoSocio'];
				$celular = $_POST['txtCelularSocio'];
				$idSocio = $_POST['idSocio'];
				$editar = new ModeloSocio();
				$respuesta = $editar->mdlEditarSocioDatos($correo, $celular, $idSocio);
				if ($respuesta > 0) {
					return 'ok';
				}else{
					return 'error';
				}
				
			}else{
				return 'novalido';
			}			
		}
		/*----------  editar un solo campo de un socio  ----------*/
		static public function ctrEditarCampoSocio($item, $valor, $idSocio){
			$respuesta = new ModeloSocio();
			$editar = $respuesta->mdlEditarCampoSocio($item, $valor, $idSocio);	
			if($editar){
				return 'ok';
			}
		}

		static public function ctrContarBenefPorSocio($idSocio){
			$respuesta = new ModeloSocio();
			return $respuesta->mdlContarBenefPorSocio($idSocio);
		}

		/*----------  contar todas los socios  ----------*/
		static public function ctrTotalSocios($idMunicipalidad, $estado){
			$respuesta = new ModeloSocio();
			return $respuesta->mdlTotalSocios($idMunicipalidad, $estado);
		}
	}