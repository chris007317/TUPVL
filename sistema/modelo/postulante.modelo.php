<?php 
	require_once 'consultas.php';
	Class ModeloPostulante{
		private $fechaNacimiento;
		private $sexoPostulante;
		private $descripcionPostulante;
		private $idPersona;
		private $idPostulante;

		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  mostrar persona  ----------*/
		public function mdlMostrarPostulante($item, $valor){
			$sql = "SELECT * FROM postulante 
				INNER JOIN personas ON idPersonaPostulante = idPersona 
				WHERE $item = '$valor' LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}

		/*----------  registrar postulante  ----------*/
		public function mdlRegistrarPostulante($fechaNacimiento, $sexoPostulante, $descripcionPostulante, $idPersona){
			$this->fechaNacimiento = $fechaNacimiento;
			$this->sexoPostulante = $sexoPostulante;
			$this->descripcionPostulante = $descripcionPostulante;
			$this->idPersona = $idPersona;
			$sql = "SELECT idPostulante FROM postulante WHERE idPersonaPostulante = $this->idPersona LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO postulante (fechaNacimiento, sexoPostulante, descripcionPostulante, idPersonaPostulante) VALUES(?,?,?,?)";
				$arrData = array($this->fechaNacimiento, $this->sexoPostulante, $this->descripcionPostulante, $this->idPersona); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$respuesta = 0;
			}
			return $respuesta;
		}

		/*----------  Editar postulante  ----------*/
    	public	function mdlEditarPostulante($sexoPostulante, $descripcionPostulante, $idPostulante){
			$this->sexoPostulante = $sexoPostulante;
			$this->descripcionPostulante = $descripcionPostulante;
			$this->idPostulante = $idPostulante;
			$sql = "UPDATE postulante SET  sexoPostulante = ?, descripcionPostulante = ? 
				WHERE idPostulante = $this->idPostulante";
			$arrData = array($this->sexoPostulante, $this->descripcionPostulante); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		/*----------  mostrar postulantes  ----------*/
		public function mdlMostrarPostulantes($fechaInicio, $fechaFin, $idMunicipalidad, $estado){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = '';
			if ($fechaInicio == '' && $fechaFin == '') {
				$sql = "SELECT idInscripcion, nombrePersona, apellidoPaternoPersona, apellidoMaternoPersona, dniPersona, personas.idDireccion,
					nombreDireccion, numero, fechaNacimiento, sexoPostulante, descripcionPostulante, idPersonaPostulante, nombreComite, 
					nombreLocalidad, nombreTipoBeneficiario, inscripcion.fechaRegistro, inscripcion.idPostulante, nombreTipoSocio, idComiteInscripcion, 
					idSocioInscripcion, idTipoSo, idTipoInscripcion, idUsuarioInscripcion, estadoInscripcion
					FROM inscripcion 
					INNER JOIN postulante ON inscripcion.idPostulante = postulante.idPostulante
				    INNER JOIN personas ON idPersonaPostulante = idPersona
				    LEFT JOIN direccion ON  personas.idDireccion = direccion.idDireccion
				    INNER JOIN comites ON idComiteInscripcion = idComite
				    INNER JOIN localidades ON idLocalidadComite = idLocalidad
				    INNER JOIN tipo_beneficiario ON idTipoInscripcion = idTipoBeneficiario
				    INNER JOIN tipo_socio ON idTipoSo = idTipoSocio
    				WHERE idMunicipalidad = $this->idMunicipalidad AND estadoInscripcion = $estado AND YEAR(fechaRegistro) = YEAR(CURRENT_DATE()) 
        			
    				ORDER BY fechaRegistro DESC";
			}else{
				$sql = "SELECT idInscripcion, nombrePersona, apellidoPaternoPersona, apellidoMaternoPersona, dniPersona, personas.idDireccion,
					nombreDireccion, numero, fechaNacimiento, sexoPostulante, descripcionPostulante, idPersonaPostulante, nombreComite, 
					nombreLocalidad, nombreTipoBeneficiario, inscripcion.fechaRegistro, inscripcion.idPostulante, nombreTipoSocio, 
					idComiteInscripcion, idSocioInscripcion, idTipoSo, idTipoInscripcion, idUsuarioInscripcion, estadoInscripcion
					FROM inscripcion 
					INNER JOIN postulante ON inscripcion.idPostulante = postulante.idPostulante
				    INNER JOIN personas ON idPersonaPostulante = idPersona
				    LEFT JOIN direccion ON  personas.idDireccion = direccion.idDireccion
				    INNER JOIN comites ON idComiteInscripcion = idComite
				    INNER JOIN localidades ON idLocalidadComite = idLocalidad
				    INNER JOIN tipo_beneficiario ON idTipoInscripcion = idTipoBeneficiario
				    INNER JOIN tipo_socio ON idTipoSo = idTipoSocio
				    WHERE idMunicipalidad = $this->idMunicipalidad AND estadoInscripcion = $estado AND fechaRegistro BETWEEN '$fechaInicio' AND '$fechaFin'
				    ORDER BY fechaRegistro DESC";
			}
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		public function mdlConsultaPostulante($idMunicipalidad, $dni){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT idInscripcion AS id, idSocioInscripcion AS socio, nombrePersona, apellidoPaternoPersona, apellidoMaternoPersona, nombreTipoBeneficiario, nombreComite, fechaRegistro AS fecha, estadoInscripcion, descripcionPostulante, nombreMunicipalidad FROM inscripcion
				INNER JOIN comites ON idComiteInscripcion= idComite
				INNER JOIN localidades ON idLocalidadComite = idLocalidad
				INNER JOIN municipalidades ON localidades.idMunicipalidad = municipalidades.idMunicipalidad
				INNER JOIN tipo_beneficiario ON idTipoInscripcion = idTipoBeneficiario
				INNER JOIN postulante ON inscripcion.idPostulante = postulante.idPostulante
				INNER JOIN personas ON idPersonaPostulante = idPersona
				WHERE dniPersona = '$dni' AND localidades.idMunicipalidad = $this->idMunicipalidad ORDER BY fechaRegistro;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;	
		}
	} 