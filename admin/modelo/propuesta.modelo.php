<?php 
	require_once 'consultas.php';
	Class ModeloPropuesta{
		public $baseDatos;
		/*----------  Mostrar municipalidades  ----------*/
		public function mdlMostrarPropuestas(){
			$this->baseDatos = ControladorRuta::ctrBdAdmin();
			$consulta = new Consultas($this->baseDatos);
			$sql = "SELECT idPropuestas, idDistrito, nombreMunicipalidad, imagenMunicipalidad, direccion, ruc, apellidoPaterno, apellidoMaterno, nombres 
					FROM propuesta 
					INNER JOIN responsables ON propuesta.idRes = responsables.idResponsable
					WHERE estadoMunicipalidad = TRUE";
			$respuesta = $consulta->selectAll($sql);
			return $respuesta;
		}
		/*----------  buscacr propuestas  ----------*/
		public function mdlBuscarPropuestas($buscar){
			$this->baseDatos = ControladorRuta::ctrBdAdmin();
			$consulta = new Consultas($this->baseDatos);
			$sql = "SELECT idPropuestas, idDistrito, nombreMunicipalidad, imagenMunicipalidad, direccion, ruc, apellidoPaterno, apellidoMaterno, nombres 
					FROM propuesta 
					INNER JOIN responsables ON propuesta.idRes = responsables.idResponsable
					WHERE nombreMunicipalidad LIKE '%".$buscar."%' AND estadoMunicipalidad = TRUE";
			$respuesta = $consulta->selectAll($sql);
			return $respuesta;
		}

		public function mdlMostrarRegion($idDistrito){
			$this->baseDatos = ControladorRuta::ctrBdSistema();
			$consulta = new Consultas($this->baseDatos);
			$sql = "SELECT nombreDistrito, nombreProvincia, nombreDepartamento FROM distritos 
					INNER JOIN provincias ON distritos.idProvincia = provincias.idProvincia
					INNER JOIN departamentos ON provincias.idDepartamento = departamentos.idDepartamento WHERE idDistrito = $idDistrito LIMIT 1";
			$respuesta = $consulta->select($sql);
			return $respuesta;	
		}

		public function mdlEditarPropuesta($item, $valor, $idPropuesta){
			$this->baseDatos = ControladorRuta::ctrBdAdmin();
			$consulta = new Consultas($this->baseDatos);
			$sql = "UPDATE propuesta SET $item = ? WHERE idPropuestas = $idPropuesta";
			$arrData = array($valor); 
			$respuesta = $consulta->update($sql, $arrData);
			return $respuesta;	
		}

		public function mdlBuscarPropuesta($item, $idPropuesta){
			$this->baseDatos = ControladorRuta::ctrBdAdmin();
			$consulta = new Consultas($this->baseDatos);
			$sql = "SELECT * FROM propuesta WHERE $item = $idPropuesta";
			$respuesta = $consulta->select($sql);
			return $respuesta;
		}

		public function mdlRegistrarMunicipalidad($nombreMuni, $imagenMuni, $direccionMuni, $ruc, $idDistrito){
			$this->baseDatos = ControladorRuta::ctrBdSistema();
			$consulta = new Consultas($this->baseDatos);
			$sql = "SELECT * FROM municipalidades WHERE ruc = '$ruc' LIMIT 1";
			$respuesta = $consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO municipalidades (nombreMunicipalidad, imagenMunicipalidad, direccionMunicipalidad, ruc, idDistritoMunicipalidad) VALUES(?,?,?,?,?)";
				$arrData = array($nombreMuni, $imagenMuni, $direccionMuni, $ruc, $idDistrito); 
				$respuesta = $consulta->insert($sql, $arrData);
			}else{
				$respuesta = 'existe';
			}
			return $respuesta;
		}

		public function mdlRegistrarPersona($nombrePersona, $apellidoMaterno, $apellidoPaterno, $dni){
			$this->baseDatos = ControladorRuta::ctrBdSistema();
			$consulta = new Consultas($this->baseDatos);
			$sql = "SELECT idPersona FROM personas WHERE dniPersona = '$dni' LIMIT 1";
			$persona = $consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO personas (nombrePersona, apellidoMaternoPersona, apellidoPaternoPersona, dniPersona) VALUES(?,?,?,?)";
				$arrData = array($nombrePersona, $apellidoMaterno, $apellidoPaterno, $dni); 
				$respuesta = $consulta->insert($sql, $arrData);
			}else{
				$respuesta = $persona['idPersona'];
			}
			return $respuesta;
		}

		public function mdlBuscarPersona($item, $valor){
			$this->baseDatos = ControladorRuta::ctrBdAdmin();
			$consulta = new Consultas($this->baseDatos);
			$sql = "SELECT * FROM responsables WHERE $item = $valor";
			$respuesta = $consulta->select($sql);
			return $respuesta;
		}

		public function mdlRegistrarUsuario($usuario, $contra, $correo, $celular, $idPersona, $tipoUsuario, $idMunicipalidad){
			$this->baseDatos = ControladorRuta::ctrBdSistema();
			$consulta = new Consultas($this->baseDatos);
			$sql = "INSERT INTO usuarios (nombreUsuario, contraUsuario, correoUsuario, celularUsuario, idPersonaUsuario, idTipoUsuario, idMunicipalidadUsuario) VALUES(?,?,?,?,?,?,?)";
			$arrData = array($usuario, $contra, $correo, $celular, $idPersona, $tipoUsuario, $idMunicipalidad); 
			$respuesta = $consulta->insert($sql, $arrData);
			return $respuesta;
		} 
	}