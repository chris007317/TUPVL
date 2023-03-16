<?php 
	require_once 'consultas.php';
	Class ModeloPresidente{
		private $correoPresidente;
		private $celularPresidente;
		private $fechaPresidente;
		private $idPersona;
		private $idComite;
		private $idPresidente;
		private $idMunicipalidad;
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  agregar persona  ----------*/
		public function mdlAgregarPresidente($correoPresidente, $celularPresidente, $fechaPresidente, $idPersona, $idComite){
			$this->correoPresidente = $correoPresidente;
			$this->celularPresidente = $celularPresidente;
			$this->fechaPresidente = $fechaPresidente;
			$this->idPersona = $idPersona;
			$this->idComite = $idComite;
			$sql = "SELECT * FROM presidentes WHERE (idPersonaPresidente = $this->idPersona AND idComitePresidente != $this->idComite AND estadoPresidente = TRUE) OR (idPersonaPresidente = $this->idPersona AND idComitePresidente = $this->idComite AND estadoPresidente = TRUE) LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO presidentes (correoPresidente, celularPresidente, fechaRegistroPresidente, idPersonaPresidente, idComitePresidente) VALUES(?,?,?,?,?)";
				$arrData = array($this->correoPresidente, $this->celularPresidente, $this->fechaPresidente, $this->idPersona, $this->idComite); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$respuesta = 'existe';
			}
			return $respuesta;
		}
		/*----------  mostrar presidente  ----------*/
		public function mdlMostrarPresidente($item, $valor){
			$sql = "SELECT idPresidente, correoPresidente, celularPresidente, fechaRegistroPresidente, personas.* FROM presidentes 
				INNER JOIN personas ON idPersonaPresidente = idPersona WHERE $item = $valor AND estadoPresidente = TRUE LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		/*----------  Editar un presidente  ----------*/
    	public	function mdlEditarPresidente($correo, $celular, $fecha, $idPresidente){
			$this->correoPresidente = $correo;
			$this->celularPresidente = $celular;
			$this->fechaPresidente = $fecha;
			$this->idPresidente = $idPresidente;
			$sql = "UPDATE presidentes SET  correoPresidente = ?, celularPresidente = ?, fechaRegistroPresidente = ? 
					WHERE idPresidente = $this->idPresidente";
			$arrData = array($this->correoPresidente, $this->celularPresidente, $this->fechaPresidente); 
			$respuesta = $this->consulta->update($sql, $arrData);
			if ($respuesta) {
				$respuesta = 'ok';
			}
			return $respuesta;
		}
		/*----------  editar un campo del presidente  ----------*/
		public function mdlEditarEstadoPresidente($item, $valor, $idPresidente){
			$this->idPresidente = $idPresidente;
			$sql = "UPDATE presidentes SET $item = ? WHERE idPresidente = $this->idPresidente";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		public function mdlMostrarPresidentes($item, $valor, $idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = '';
			if ($item != '' && $valor != '') {
				$sql = "SELECT apellidoPaternoPersona, apellidoMaternoPersona, nombrePersona, dniPersona, presidentes.*, nombreComite, nombreLocalidad, personas.idDireccion, nombreDireccion, numero FROM presidentes
					INNER JOIN personas ON idPersonaPresidente = idPersona
					LEFT JOIN direccion ON  personas.idDireccion = direccion.idDireccion
				    INNER JOIN comites ON idComitePresidente = idComite
				    INNER JOIN localidades ON idLocalidadComite = idLocalidad 
				    WHERE estadoLocalidad = TRUE AND idMunicipalidad = $this->idMunicipalidad AND estadoComite = TRUE AND $item = $valor
				    ORDER BY nombreLocalidad ASC";
			}else{
				$sql = "SELECT apellidoPaternoPersona, apellidoMaternoPersona, nombrePersona, dniPersona, presidentes.*, nombreComite, nombreLocalidad, personas.idDireccion, nombreDireccion, numero FROM presidentes 
					INNER JOIN personas ON idPersonaPresidente = idPersona
					LEFT JOIN direccion ON  personas.idDireccion = direccion.idDireccion
				    INNER JOIN comites ON idComitePresidente = idComite
				    INNER JOIN localidades ON idLocalidadComite = idLocalidad 
				    WHERE idMunicipalidad = $this->idMunicipalidad AND estadoLocalidad = TRUE AND estadoComite = TRUE
				    ORDER BY nombreLocalidad ASC";
			}
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/*----------  Contar presidendtes  ----------*/
		public function mdlContarPresidentes($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT COUNT(idMunicipalidad) AS total,  SUM(CASE WHEN estadoPresidente = TRUE THEN 1 ELSE 0 END) AS cantidad FROM presidentes 
				INNER JOIN comites ON idComitePresidente = idComite 
			    INNER JOIN localidades ON idLocalidadComite = idLocalidad
			    WHERE idMunicipalidad = $this->idMunicipalidad;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
	}