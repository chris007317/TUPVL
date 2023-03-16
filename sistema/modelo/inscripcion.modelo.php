<?php 
	require_once 'consultas.php';
	Class ModeloInscripcion{
		private $fechaRegistro;
		private $idPostulante;
		private $idComite;
		private $idSocio;
		private $idTipoSocio;
		private $idTipoInscripcion;
		private $idUsuario;
		private $idInscripcion;
		private $idRequisto;
		private $idMunicipalidad;

		public function __construct(){
			$this->consulta = new Consultas();
		}

		/*----------  registrar postulante  ----------*/
		public function mdlRegistrarInscripcion($fechaRegistro, $idPostulante, $idComite, $idSocio, $idTipoSocio, $idTipoInscripcion, $idUsuario){
			$this->fechaRegistro = $fechaRegistro;
			$this->idPostulante = $idPostulante;
			$this->idComite = $idComite;
			$this->idSocio = $idSocio;
			$this->idTipoSocio = $idTipoSocio;
			$this->idTipoInscripcion = $idTipoInscripcion;
			$this->idUsuario = $idUsuario;
			$sql = "INSERT INTO inscripcion (fechaRegistro, idPostulante, idComiteInscripcion, idSocioInscripcion, idTipoSo, idTipoInscripcion, idUsuarioInscripcion) VALUES(?,?,?,?,?,?,?)";
			$arrData = array($this->fechaRegistro, $this->idPostulante, $this->idComite, $this->idSocio, $this->idTipoSocio, $this->idTipoInscripcion, $this->idUsuario); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}

				/*----------  registrar postulante  ----------*/
		public function mdlRegistrarRequisito($idInscripcion, $idRequisto){
			$this->idInscripcion = $idInscripcion;
			$this->idRequisto = $idRequisto;
			$sql = "INSERT INTO requisito_inscripcion (idInscripcion, idReMuni) VALUES(?,?)";
			$arrData = array($this->idInscripcion, $this->idRequisto); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}

		/*----------  mostrar inscripcion  ----------*/
		public function mdlMostrarInscripcion($item, $valor){
			$sql = "SELECT idInscripcion, DATE_FORMAT(fechaRegistro, '%d-%m-%Y') AS fechaInscripcion, DATE_FORMAT(fechaRegistro, '%H:%i:%s') AS horaRegistro, estadoInscripcion, idPostulante, idComiteInscripcion, 
					nombreComite, idLocalidadComite, idSocioInscripcion, nombreTipoSocio, idTipoInscripcion, nombreTipoBeneficiario, idUsuarioInscripcion, idTipoSo FROM inscripcion 
				INNER JOIN comites ON idComiteInscripcion = idComite 
				INNER JOIN tipo_socio ON idTipoSo = idTipoSocio
				INNER JOIN tipo_beneficiario ON idTipoInscripcion = idTipoBeneficiario
				WHERE $item = $valor LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}

		/*----------  Tabla requistos cumplidos  ----------*/
		public function mdlMostrarRequistosInscripcion($idInscripcion){
			$this->idInscripcion = $idInscripcion;
			$sql = "SELECT * FROM requisito_inscripcion WHERE idInscripcion = $this->idInscripcion";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}		
		/*----------  editar inscripcion por un campo  ----------*/
		public function mdlEditarInscripcion($item, $valor, $idInscripcion){
			$this->idInscripcion = $idInscripcion;
			$sql = "UPDATE inscripcion SET $item = ? WHERE idInscripcion = $this->idInscripcion";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}

		public function mdlEditarPostulante($descripcion, $sexo, $idPostulante){
			$this->idPostulante = $idPostulante;
			$sql = "UPDATE postulante SET sexoPostulante = ?, descripcionPostulante = ? WHERE idPostulante = $this->idPostulante";
			$arrData = array($sexo, $descripcion); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;	
		}

		public function mdlNuevosInscritos($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT COUNT(idInscripcion) AS total FROM inscripcion 
				INNER JOIN comites ON idComiteInscripcion = idComite 
    			INNER JOIN localidades ON idLocalidadComite = idLocalidad
    			WHERE DAY(fechaRegistro)  = DAY(CURRENT_DATE()) AND estadoInscripcion = 1 AND idMunicipalidad = $this->idMunicipalidad";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;	
		}

		public function mdlTotalInscritos($idMunicipalidad, $estado){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT COUNT(idInscripcion) AS total FROM inscripcion 
				INNER JOIN comites ON idComiteInscripcion = idComite 
    			INNER JOIN localidades ON idLocalidadComite = idLocalidad
    			WHERE estadoInscripcion = $estado AND idMunicipalidad = $this->idMunicipalidad";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;	
		}

		public function mdlPorcentajeInscritos($idMunicipalidad, $estado){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT COUNT(idInscripcion) AS total, SUM(CASE WHEN estadoInscripcion = $estado THEN 1 ELSE 0 END) AS cantidad FROM inscripcion 
				INNER JOIN comites ON idComiteInscripcion = idComite 
    			INNER JOIN localidades ON idLocalidadComite = idLocalidad
			    WHERE idMunicipalidad = $this->idMunicipalidad";
		    $respuesta = $this->consulta->select($sql);
			return $respuesta;	
		}
	}  