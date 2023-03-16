<?php 
	require_once 'consultas.php';
	Class ModeloBeneficiario{
		private $dni;
		private $nombrePersona;
		private $apellidoMaterno;
		private $apellidoPaterno;
		private $idPersona; 
		private $idPostulante;
		private $idTipoBeneficiario;
		private $idSocioBeneficiario;
		private $idTipoSocio;
		private $idEstado;
		private $idComiteBeneficiario;
		private $idUsuario;
		private $fechaRegistro;
		private $fechaVencimiento;
		private $estado;
		private $idBeneficiario;
		private $idEstadoBenef;

		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  mostrar persona  ----------*/
		public function mdlMostrarBeneficiario($item, $valor){
			$sql = "SELECT beneficiario_inscripcion.*, postulante.*, apellidoPaternoPersona, apellidoMaternoPersona, nombrePersona, dniPersona FROM beneficiario_inscripcion 
				INNER JOIN postulante ON idPostBenef = idPostulante 
			    INNER JOIN personas ON idPersonaPostulante = idPersona
			    WHERE $item = '$valor' AND idEstadoBenef = 1 LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		/*----------  Agregar nuevo beneficiario  ----------*/
		public function mdlAgregarBeneficiario($idPostulante, $idTipoBeneficiario, $idSocioBeneficiario, $idTipoSocio, $idEstado, $idComiteBeneficiario, $idUsuario, $fechaRegistro, $fechaVencimiento){
			$this->idPostulante = $idPostulante;
			$this->idTipoBeneficiario = $idTipoBeneficiario;
			$this->idSocioBeneficiario = $idSocioBeneficiario;
			$this->idTipoSocio = $idTipoSocio;
			$this->idEstado = $idEstado;
			$this->idComiteBeneficiario = $idComiteBeneficiario;
			$this->idUsuario = $idUsuario;
			$this->fechaRegistro = $fechaRegistro;
			$this->fechaVencimiento = $fechaVencimiento;
			$sql = "INSERT INTO beneficiario_inscripcion(idPostBenef, idTipoBenef, idSocioBenef, idTipoSocioBenef, idEstadoBenef, idComiteBenef, idUsuarioBenef, fechaInscripcion, fechaVencimiento) VALUES (?,?,?,?,?,?,?,?,?)";
			$arrData = array($this->idPostulante, $this->idTipoBeneficiario, $this->idSocioBeneficiario, $this->idTipoSocio, $this->idEstado, $this->idComiteBeneficiario, $this->idUsuario, $this->fechaRegistro, $this->fechaVencimiento); 
			$respuesta = $this->consulta->insert($sql, $arrData);	
			return $respuesta;
		}
		/*----------  mostrar lista de beneficiarios  ----------*/
		public function mdlMostrarBeneficiarios($idMunicipalidad, $item, $valor, $fechaInicio, $fechaFin, $idEstado){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = '';
			if ($item == '' && $valor == '' && $fechaInicio == '' && $fechaFin == '') {
				$sql = "SELECT idInscripcionBenef, fechaInscripcion, fechaVencimiento, fechaNacimiento, sexoPostulante, descripcionPostulante, dniPersona, nombrePersona, 
				apellidoPaternoPersona, apellidoMaternoPersona, personas.idDireccion, nombreDireccion, numero, nombreTipoBeneficiario, nombreTipoSocio,
				nombreEstadoBeneficiario, idPostBenef, nombreComite, nombreLocalidad, idTipoBenef, idSocioBenef, idTipoSocioBenef, idEstadoBenef, 
				idComiteBenef, idUsuarioBenef, estadoInscripcionBenef, idPersonaPostulante
				    FROM beneficiario_inscripcion
					INNER JOIN postulante ON idPostBenef = idPostulante
				    INNER JOIN personas ON idPersonaPostulante = idPersona
				    LEFT JOIN direccion ON personas.idDireccion = direccion.idDireccion
				    INNER JOIN tipo_beneficiario ON idTipoBenef = idTipoBeneficiario
				    INNER JOIN tipo_socio ON idTipoSocioBenef = idTipoSocio
				    INNER JOIN estado_beneficiario ON idEstadoBenef = idEstadoBeneficiario
				    INNER JOIN comites ON idComiteBenef = idComite
				    INNER JOIN localidades ON idLocalidadComite = idLocalidad
				    WHERE idMunicipalidad = $this->idMunicipalidad AND  estadoComite = 1 AND estadoLocalidad = 1 AND idEstadoBenef = $idEstado 
				    ORDER BY nombreLocalidad ASC;";
			}else if ($item == '' && $valor == '') {
				$sql = "SELECT idInscripcionBenef, fechaInscripcion, fechaVencimiento, fechaNacimiento, sexoPostulante, descripcionPostulante, dniPersona, nombrePersona, 
				apellidoPaternoPersona, apellidoMaternoPersona, personas.idDireccion, nombreDireccion, numero, nombreTipoBeneficiario, nombreTipoSocio,
				nombreEstadoBeneficiario, idPostBenef, nombreComite, nombreLocalidad, idTipoBenef, idSocioBenef, idTipoSocioBenef, idEstadoBenef, 
				idComiteBenef, idUsuarioBenef, estadoInscripcionBenef, idPersonaPostulante
				    FROM beneficiario_inscripcion
					INNER JOIN postulante ON idPostBenef = idPostulante
				    INNER JOIN personas ON idPersonaPostulante = idPersona
				    LEFT JOIN direccion ON personas.idDireccion = direccion.idDireccion
				    INNER JOIN tipo_beneficiario ON idTipoBenef = idTipoBeneficiario
				    INNER JOIN tipo_socio ON idTipoSocioBenef = idTipoSocio
				    INNER JOIN estado_beneficiario ON idEstadoBenef = idEstadoBeneficiario
				    INNER JOIN comites ON idComiteBenef = idComite
				    INNER JOIN localidades ON idLocalidadComite = idLocalidad
				    WHERE idMunicipalidad = $this->idMunicipalidad AND estadoComite = 1 AND estadoLocalidad = 1 AND fechaInscripcion BETWEEN '$fechaInicio' AND '$fechaFin' AND idEstadoBenef = $idEstado 
				    ORDER BY fechaInscripcion DESC;";
			}else if ($fechaInicio == '' && $fechaFin == '') {
				$sql = "SELECT idInscripcionBenef, fechaInscripcion, fechaVencimiento, fechaNacimiento, sexoPostulante, descripcionPostulante, dniPersona, nombrePersona, 
				apellidoPaternoPersona, apellidoMaternoPersona, personas.idDireccion, nombreDireccion, numero, nombreTipoBeneficiario, nombreTipoSocio,
				nombreEstadoBeneficiario, idPostBenef, nombreComite, nombreLocalidad, idTipoBenef, idSocioBenef, idTipoSocioBenef, idEstadoBenef, 
				idComiteBenef, idUsuarioBenef, estadoInscripcionBenef, idPersonaPostulante
				    FROM beneficiario_inscripcion
					INNER JOIN postulante ON idPostBenef = idPostulante
				    INNER JOIN personas ON idPersonaPostulante = idPersona
				    LEFT JOIN direccion ON personas.idDireccion = direccion.idDireccion
				    INNER JOIN tipo_beneficiario ON idTipoBenef = idTipoBeneficiario
				    INNER JOIN tipo_socio ON idTipoSocioBenef = idTipoSocio
				    INNER JOIN estado_beneficiario ON idEstadoBenef = idEstadoBeneficiario
				    INNER JOIN comites ON idComiteBenef = idComite
				    INNER JOIN localidades ON idLocalidadComite = idLocalidad
				    WHERE idMunicipalidad = $this->idMunicipalidad AND $item = '$valor' AND idEstadoBenef = $idEstado AND estadoComite = 1 AND estadoLocalidad = 1
				    ORDER BY apellidoPaternoPersona ASC;";
			}else{
				$sql = "SELECT idInscripcionBenef, fechaInscripcion, fechaVencimiento, fechaNacimiento, sexoPostulante, descripcionPostulante, dniPersona, nombrePersona, 
				apellidoPaternoPersona, apellidoMaternoPersona, personas.idDireccion, nombreDireccion, numero, nombreTipoBeneficiario, nombreTipoSocio,
				nombreEstadoBeneficiario, idPostBenef, nombreComite, nombreLocalidad, idTipoBenef, idSocioBenef, idTipoSocioBenef, idEstadoBenef, 
				idComiteBenef, idUsuarioBenef, estadoInscripcionBenef, idPersonaPostulante
				    FROM beneficiario_inscripcion
					INNER JOIN postulante ON idPostBenef = idPostulante
				    INNER JOIN personas ON idPersonaPostulante = idPersona
				    LEFT JOIN direccion ON personas.idDireccion = direccion.idDireccion
				    INNER JOIN tipo_beneficiario ON idTipoBenef = idTipoBeneficiario
				    INNER JOIN tipo_socio ON idTipoSocioBenef = idTipoSocio
				    INNER JOIN estado_beneficiario ON idEstadoBenef = idEstadoBeneficiario
				    INNER JOIN comites ON idComiteBenef = idComite
				    INNER JOIN localidades ON idLocalidadComite = idLocalidad
				    WHERE idMunicipalidad = $this->idMunicipalidad AND $item = '$valor' AND estadoComite = 1 AND estadoLocalidad = 1 AND fechaInscripcion 
				    BETWEEN '$fechaInicio' AND '$fechaFin' AND idEstadoBenef = $idEstado 
				    ORDER BY fechaInscripcion DESC;";	
			}
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		} 

		/*----------  Editar un campo de un beneficiario  ----------*/
		public function mdlEditarCampoBeneficiario($item, $valor, $idBeneficiario){
			$this->idBeneficiario = $idBeneficiario;
			$sql = "UPDATE beneficiario_inscripcion SET $item = ? WHERE idInscripcionBenef = $this->idBeneficiario";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}

		/*----------  datos beneficiario  ----------*/
		public function mdlDatosBeneficiario($item, $valor, $idEstadoBenef){
			$sql = "SELECT fechaNacimiento, sexoPostulante, descripcionPostulante, dniPersona, nombrePersona, apellidoPaternoPersona, apellidoMaternoPersona, 
				nombreTipoBeneficiario, nombreTipoSocio, nombreEstadoBeneficiario, nombreComite, nombreLocalidad, idInscripcionBenef, nombreTipoSocio,
			    idPostBenef, idTipoBenef, idSocioBenef, idEstadoBenef, idComiteBenef, idUsuarioBenef, fechaInscripcion, fechaVencimiento, idTipoSocioBenef
			    FROM beneficiario_inscripcion
				INNER JOIN postulante ON idPostBenef = idPostulante
			    INNER JOIN personas ON idPersonaPostulante = idPersona
			    INNER JOIN tipo_beneficiario ON idTipoBenef = idTipoBeneficiario
			    INNER JOIN tipo_socio ON idTipoSocioBenef = idTipoSocio
			    INNER JOIN estado_beneficiario ON idEstadoBenef = idEstadoBeneficiario
			    INNER JOIN comites ON idComiteBenef = idComite
			    INNER JOIN localidades ON idLocalidadComite = idLocalidad
			    WHERE $item = '$valor' AND idEstadoBenef = $idEstadoBenef AND estadoComite = 1 AND estadoLocalidad = 1 LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}

		/*----------  mostrar tipo de beneficiarios  ----------*/
		public function mdlMostrarEstadoBeneficiario(){
			$sql = "SELECT * FROM estado_beneficiario";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}

		/*----------  Editar un beneficiario  ----------*/
		public function mdlEditarBeneficiario($idTipoSocio,  $idEstadoBenef, $idBeneficiario, $idComite){
			$this->idBeneficiario = $idBeneficiario;
			$this->idTipoSocio = $idTipoSocio;
			$this->idEstadoBenef = $idEstadoBenef;
			$this->idComiteBeneficiario = $idComite;
			$sql = "UPDATE beneficiario_inscripcion SET idTipoSocioBenef = ?, idEstadoBenef = ? , idComiteBenef = ? WHERE idInscripcionBenef = $this->idBeneficiario";
			$arrData = array($this->idTipoSocio, $this->idEstadoBenef, $this->idComiteBeneficiario); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}

		public function mdlTotalBeneficiarios($idMunicipalidad, $estado){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT COUNT(idInscripcionBenef) AS total FROM beneficiario_inscripcion
				INNER JOIN comites ON idComiteBenef = idComite
		    	INNER JOIN localidades ON idLocalidadComite = idLocalidad 
    			WHERE idEstadoBenef = $estado AND idMunicipalidad = $this->idMunicipalidad AND estadoComite = 1 AND estadoLocalidad = 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;	
		}

		public function mdlTotalBeneficiariosActivosMes($idMunicipalidad, $mes, $year, $estado){
			$this->idMunicipalidad = $idMunicipalidad; 
			$sql = "SELECT COUNT(idInscripcionBenef) AS total FROM beneficiario_inscripcion
				INNER JOIN comites ON idComiteBenef = idComite
				INNER JOIN localidades ON idLocalidadComite = idLocalidad 
				WHERE idEstadoBenef = $estado AND idMunicipalidad = $this->idMunicipalidad AND estadoComite = 1 AND estadoLocalidad = 1 AND fechaInscripcion <= '".$year."-".$mes."-01';";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;	
		}

		public function mdlContarBenefPorVencer($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT COUNT(idInscripcionBenef) AS total FROM beneficiario_inscripcion
				INNER JOIN comites ON idComiteBenef = idComite
		    	INNER JOIN localidades ON idLocalidadComite = idLocalidad 
    			WHERE fechaVencimiento >= CURDATE() AND fechaVencimiento <= DATE_ADD(CURDATE(), INTERVAL 5 DAY) 
    				AND idMunicipalidad = $this->idMunicipalidad AND idEstadoBenef = 1 AND estadoComite = 1 AND estadoLocalidad = 1;";
    		$respuesta = $this->consulta->select($sql);
    		return $respuesta;
		}

		public function mdlContarPorMes($idMunicipalidad, $mes, $year, $estado){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT COUNT(idInscripcionBenef) AS total FROM beneficiario_inscripcion
				INNER JOIN comites ON idComiteBenef = idComite
		    	INNER JOIN localidades ON idLocalidadComite = idLocalidad 
    			WHERE idEstadoBenef = $estado  AND idMunicipalidad = $this->idMunicipalidad AND estadoComite = 1 AND estadoLocalidad = 1 AND fechaVencimiento < '".$year."-".$mes."-01';";
    		$respuesta = $this->consulta->select($sql);
    		return $respuesta;
		} 

				/*----------  mostrar lista de beneficiarios  ----------*/
		public function mdlMostrarBeneficiariosMes($idMunicipalidad, $idEstado){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT idInscripcionBenef, MONTH(fechaVencimiento) AS mesVencimiento, YEAR(fechaVencimiento) AS yearVencimiento, fechaVencimiento, idComiteBenef, MONTH(fechaInscripcion) AS mesRegistro, YEAR(fechaInscripcion) AS yearRegistro 
				FROM beneficiario_inscripcion 
				INNER JOIN comites ON idComiteBenef = idComite
		    	INNER JOIN localidades ON idLocalidadComite = idLocalidad
                WHERE idEstadoBenef = $idEstado AND idMunicipalidad = $this->idMunicipalidad AND estadoComite = 1 AND estadoLocalidad = 1 order by yearVencimiento;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		} 
		/*----------  mostrar lista de beneficiarios por mes  ----------*/
		public function mdlMostrarBeneficiariosMesVal($idMunicipalidad, $idEstado, $mes, $year){
			$this->idMunicipalidad = $idMunicipalidad;
			/* consulta modificada para saber quienes son los beneficiarios que van a recibir racion */
			/* 
				$sql = "SELECT idInscripcionBenef, MONTH(fechaVencimiento) AS mesVencimiento, YEAR(fechaVencimiento) AS yearVencimiento, fechaVencimiento, idComiteBenef FROM beneficiario_inscripcion
					INNER JOIN comites ON idComiteBenef = idComite
					INNER JOIN localidades ON idLocalidadComite = idLocalidad 
				WHERE idEstadoBenef = $idEstado AND idMunicipalidad = $this->idMunicipalidad AND estadoComite = 1 AND estadoLocalidad = 1 AND MONTH(fechaInscripcion) <= $mes  AND YEAR(fechaInscripcion) <= $year;";
			 */

			$sql="SELECT idInscripcionBenef, idComiteBenef FROM beneficiario_inscripcion
				INNER JOIN comites ON idComiteBenef = idComite
		    	INNER JOIN localidades ON idLocalidadComite = idLocalidad 
    			WHERE idEstadoBenef = $idEstado  AND idMunicipalidad = $this->idMunicipalidad AND estadoComite = 1 AND estadoLocalidad = 1 AND (fechaVencimiento >= '".$year."-".$mes."-01' OR fechaVencimiento IS NULL ) AND fechaInscripcion < '".$year."-".$mes."-01';";
			
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}

		public function mdlContarBeneficiarioComites($idMunicipalidad, $mes, $year){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT nombreLocalidad, nombreComite, count(idComiteBenef) AS totalBeneficiarios FROM beneficiario_inscripcion
				LEFT JOIN comites ON idComiteBenef = idComite
				LEFT JOIN localidades ON idLocalidadComite = idLocalidad 
				WHERE idEstadoBenef = $idEstado AND idMunicipalidad = $this->idMunicipalidad AND idEstadoBenef = 1 AND estadoComite = 1 AND estadoLocalidad = 1 AND MONTH(fechaVencimiento) < $mes AND YEAR(fechaVencimiento) <= $year;
				GROUP BY idComiteBenef;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;	
		}
		/*----------  mostrar tabla de un postulante  ----------*/
		public function mdlConsultaBeneficiario($idMunicipalidad, $dni){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT idInscripcionBenef AS id, idSocioBenef AS socio, nombrePersona, apellidoPaternoPersona, apellidoMaternoPersona, nombreTipoBeneficiario, nombreComite, fechaInscripcion AS fecha, nombreEstadoBeneficiario, estilo, descripcionPostulante, nombreMunicipalidad FROM beneficiario_inscripcion 
				INNER JOIN comites ON idComiteBenef = idComite
				INNER JOIN localidades ON idLocalidadComite = idLocalidad
				INNER JOIN municipalidades ON localidades.idMunicipalidad = municipalidades.idMunicipalidad
				INNER JOIN tipo_beneficiario ON idTipoBenef = idTipoBeneficiario
				INNER JOIN estado_beneficiario ON idEstadoBenef = idEstadoBeneficiario
				INNER JOIN postulante ON idPostBenef = idPostulante
				INNER JOIN personas ON idPersonaPostulante = idPersona
				WHERE dniPersona = '$dni' AND localidades.idMunicipalidad = $this->idMunicipalidad AND estadoComite = 1 AND estadoLocalidad = 1 ORDER BY fechaInscripcion;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;	
		}
		/*----------  consulta par el reporte  ----------*/
		public function mdlReporteBeneficiario($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql="SELECT persona.nombrePersona AS nombre, persona.apellidoPaternoPersona AS apPaterno, persona.apellidoMaternoPersona AS apMaterno, persona.dniPersona AS dni,
					nombreDireccion, numero, direccion.descripcion AS dirDescripcion, fechaNacimiento, sexoPostulante, descripcionPostulante, nombreTipoBeneficiario, 
					nombreComite, fechaInscripcion, fechaVencimiento, nombreEstadoBeneficiario, nombreLocalidad, socio.nombrePersona AS socioNombre, 
					socio.apellidoPaternoPersona AS socioPaterno, socio.apellidoMaternoPersona AS socioMaterno
			    FROM beneficiario_inscripcion
			    INNER JOIN postulante ON idPostBenef = idPostulante
			    INNER JOIN personas AS persona ON idPersonaPostulante = persona.idPersona
			    INNER JOIN direccion ON persona.idDireccion = direccion.idDireccion
			    INNER JOIN tipo_beneficiario ON idTipoBenef = idTipoBeneficiario
			    INNER JOIN estado_beneficiario ON idEstadoBenef = idEstadoBeneficiario
			    INNER JOIN comites ON idComiteBenef = idComite
			    INNER JOIN localidades ON idLocalidadComite = idLocalidad
			    INNER JOIN socios ON idSocioBenef = idSocio
			    INNER JOIN personas AS socio ON idPersonaSocio = socio.idPersona 
			    WHERE localidades.idMunicipalidad = $this->idMunicipalidad AND estadoComite = 1 AND estadoLocalidad = 1 ORDER BY fechaInscripcion DESC;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}	
		/*----------  consulta par el reporte  ----------*/
		public function mdlReportePostulante($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql="SELECT persona.nombrePersona AS nombre, persona.apellidoPaternoPersona AS apMaterno, persona.apellidoMaternoPersona AS apPaterno, persona.dniPersona AS dni, 
				nombreDireccion, numero, direccion.descripcion AS dirDescripcion,fechaNacimiento, sexoPostulante, descripcionPostulante, nombreTipoBeneficiario, nombreComite,
				fechaRegistro, estadoInscripcion, nombreLocalidad, socio.nombrePersona AS socioNombre, socio.apellidoPaternoPersona AS socioPaterno, 
				socio.apellidoMaternoPersona AS socioMaterno
				FROM inscripcion
				INNER JOIN postulante ON inscripcion.idPostulante = postulante.idPostulante
			    INNER JOIN personas AS persona ON  persona.idPersona = idPersonaPostulante
			    INNER JOIN direccion ON persona.idDireccion = direccion.idDireccion
			    INNER JOIN tipo_beneficiario ON idTipoInscripcion = idTipoBeneficiario
			    INNER JOIN comites ON idComiteInscripcion = idComite
			    INNER JOIN localidades ON idLocalidadComite = idLocalidad
			    INNER JOIN socios ON idSocioInscripcion = idSocio
			    INNER JOIN personas AS socio ON idPersonaSocio = socio.idPersona 
			    WHERE localidades.idMunicipalidad = $this->idMunicipalidad AND estadoComite = 1 AND estadoLocalidad = 1 ORDER BY fechaRegistro DESC;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}	
		/*----------  contar beneficiarios por tipo  ----------*/
		public function mdlGrficaBenef($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql="SELECT idTipoBenef, nombreTipoBeneficiario, COUNT(idInscripcionBenef) AS total FROM beneficiario_inscripcion 
				INNER JOIN tipo_beneficiario ON idTipoBenef = idTipoBeneficiario
				INNER JOIN comites ON idComiteBenef = idComite
				INNER JOIN localidades ON idLocalidadComite = idLocalidad
				INNER JOIN postulante ON idPostBenef = idPostulante
				WHERE idMunicipalidad = $this->idMunicipalidad AND estadoComite = 1 AND estadoLocalidad = 1 AND idEstadoBenef = 1
				GROUP BY idTipoBenef";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}	
		/*----------  contar beneficiarios por tipo  ----------*/
		public function mdlValBenef($idMunicipalidad, $mes, $year, $consulta){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql="SELECT COUNT(idProgramarEntrega) AS total FROM programar_entregas 
				INNER JOIN productos ON idProductoEntrega = idProducto
				WHERE idMunicipalidadProducto = $this->idMunicipalidad AND mesEntrega >= $mes AND yearEntrega >= $year
				AND estadoProgramar = 0 $consulta;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}	
		public function mdlVerPeriodos($idMunicipalidad, $estado){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql="SELECT COUNT(idProgramarEntrega) AS total FROM programar_entregas 
				INNER JOIN productos ON idProductoEntrega = idProducto
			    WHERE idMunicipalidadProducto = $this->idMunicipalidad AND estadoProgramar = $estado;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		/*----------  mostrar los beneficiarios del comite para busqueda en padron  ----------*/
		public function mdlBenefPadron($idComite, $mes, $year){
			$sql = "SELECT idInscripcionBenef, nombrePersona, apellidoPaternoPersona, apellidoMaternoPersona, dniPersona
				FROM beneficiario_inscripcion 
				INNER JOIN postulante ON idPostBenef = idPostulante
		        INNER JOIN personas ON idPersonaPostulante = idPersona
		        WHERE idComiteBenef = $idComite AND fechaInscripcion <= '".$year."-".$mes."-01'";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}

		/* consulta para saber el número de beneficiarios activos en un rango de fecha */
		public function mdlBeneficiariosActivos($idMunicipalidad, $mes, $year, $estado){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT COUNT(idInscripcionBenef) AS total FROM beneficiario_inscripcion
				INNER JOIN comites ON idComiteBenef = idComite
		    	INNER JOIN localidades ON idLocalidadComite = idLocalidad 
    			WHERE idEstadoBenef = $estado  AND idMunicipalidad = $this->idMunicipalidad AND estadoComite = 1 AND estadoLocalidad = 1 AND fechaVencimiento < '".$year."-".$mes."-01';";
    		$respuesta = $this->consulta->select($sql);
    		return $respuesta;
		}



	}
