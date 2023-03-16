<?php 
	require_once 'consultas.php';
	Class ModeloSocio{
		private $correo;
		private $celular;
		private $idPersona;
		private $idSocio;
		private $idMunicipalidad;

		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  mostrar persona  ----------*/
		public function mdlMostrarSocio($item, $valor, $idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT socios.*, dniPersona, apellidoPaternoPersona, apellidoMaternoPersona, nombrePersona, idDireccion FROM socios 
				INNER JOIN personas ON idPersonaSocio = idPersona 
				WHERE $item = '$valor' AND idMuniSocio = $this->idMunicipalidad LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		/*----------  agregar socio  ----------*/
		public function mdlAgregarSocio($correo, $celular, $idPersona, $idMunicipalidad){
			$this->correo = $correo;
			$this->celular = $celular;
			$this->idPersona = $idPersona;
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "INSERT INTO socios (correoSocio, celular, idPersonaSocio, idMuniSocio) VALUES(?,?,?,?)";
			$arrData = array($this->correo, $this->celular, $this->idPersona, $this->idMunicipalidad); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}
		/*----------  Mostrar socios  ----------*/
		public function mdlMostrarSocios($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT socios.*, dniPersona, apellidoPaternoPersona, apellidoMaternoPersona, nombrePersona, nombreDireccion, numero, descripcion, idDistrito FROM socios 
				INNER JOIN personas ON idPersonaSocio = idPersona 
				INNER JOIN direccion ON personas.idDireccion = direccion.idDireccion 
				WHERE idMuniSocio = $this->idMunicipalidad AND estadoSocio = TRUE";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		public function mdlMostrarTiposSocios(){
			$sql = "SELECT * FROM tipo_socio ORDER BY nombreTipoSocio ASC";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;	
		}
		/*----------  listar socios por municipalidad  ----------*/
		public function mdlListarSocios($idMunicipalidad, $estado){
			$this->idMunicipalidad = $idMunicipalidad;
			if ($estado == '') {
				$sql = "SELECT idSocio, correoSocio, celular, estadoSocio, idPersonaSocio, nombrePersona, apellidoPaternoPersona, 
						apellidoMaternoPersona, dniPersona, personas.idDireccion, nombreDireccion, numero, descripcion FROM socios 
					INNER JOIN personas ON idPersonaSocio = idPersona
					INNER JOIN direccion ON personas.idDireccion = direccion.idDireccion 
					WHERE idMuniSocio = $this->idMunicipalidad ;";				
			}else{
				$sql = "SELECT idSocio, correoSocio, celular, estadoSocio, idPersonaSocio, nombrePersona, apellidoPaternoPersona, 
						apellidoMaternoPersona, dniPersona, personas.idDireccion, nombreDireccion, numero, descripcion FROM socios 
					INNER JOIN personas ON idPersonaSocio = idPersona
					INNER JOIN direccion ON personas.idDireccion = direccion.idDireccion 
					WHERE estadoSocio = $estado AND idMuniSocio = $this->idMunicipalidad ;";
			}
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
			/*----------  Editar un campo de un producto  ----------*/
		public function mdlEditarSocioDatos($correo, $celular, $idSocio){
			$this->correo = $correo;
			$this->celular = $celular;
			$this->idSocio = $idSocio;
			$sql = "UPDATE socios SET correoSocio = ?, celular = ? WHERE idSocio = $this->idSocio";
			$arrData = array($this->correo, $this->celular); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}

		/*----------  Editar un campo de un socio  ----------*/
		public function mdlEditarCampoSocio($item, $valor, $idSocio){
			$this->idSocio = $idSocio; 
			$sql = "UPDATE socios SET $item = ? WHERE idSocio = $this->idSocio;";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}

		/*----------  contar beneficiarios por socio  ----------*/
		public function mdlContarBenefPorSocio($idSocio){
			$this->idSocio = $idSocio;
			$sql = "SELECT COUNT(idInscripcionBenef) AS total FROM beneficiario_inscripcion 
				WHERE idSocioBenef = $this->idSocio AND idEstadoBenef = 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}

		public function mdlTotalSocios($idMunicipalidad, $estado){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT COUNT(idSocio) AS total FROM socios
    			WHERE estadoSocio = $estado AND idMuniSocio = $this->idMunicipalidad";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;	
		}

		
	}