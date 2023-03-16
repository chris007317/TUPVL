<?php 
	require_once 'consultas.php';
	Class ModeloMunicipalidad{
		public $idMunicipalidad;
		public $nombreMunicipalidad;
		private $imgMunicipalidad;
		public $horaEntrada;
		public $horaSalida;
		private $consulta;
		private $idUsuario;
		private $idProducto;
		private $mesEntrega;
		private $cantidad;
		private $year;

		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  Mostrar Departamentos  ----------*/
		public function mdlMostrarMunicipalidad($atributo, $valor){
			$sql = "SELECT municipalidades.*, nombreDistrito, nombreProvincia, nombreDepartamento FROM municipalidades 
				INNER JOIN distritos ON idDistritoMunicipalidad = idDistrito
			    INNER JOIN provincias ON distritos.idProvincia = provincias.idProvincia
			    INNER JOIN departamentos ON provincias.idDepartamento = departamentos.idDepartamento 
			    WHERE $atributo = '$valor' AND estadoMunicipalidad = TRUE LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		/*----------  Editar horario de la municipalidad  ----------*/
		public function mdlEditarHorario($horaEntrada, $horaSalida, $idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$this->horaEntrada = $horaEntrada;
			$this->horaSalida = $horaSalida;
			$sql = "UPDATE municipalidades SET horaEntrada = ?, horaSalida = ? WHERE idMunicipalidad = $this->idMunicipalidad";
			$arrData = array($this->horaEntrada, $this->horaSalida); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		/*----------  Editar imagen municipalidad  ----------*/
		public function mdlEditarImgMuni($imgMunicipalidad, $idMunicipalidad){
			$this->imgMunicipalidad = $imgMunicipalidad;
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "UPDATE municipalidades SET imagenMunicipalidad = ? WHERE idMunicipalidad = $this->idMunicipalidad";
			$arrData = array($this->imgMunicipalidad); 
			$respuesta = $this->consulta->update($sql, $arrData);
			if ($respuesta) {
				return 'ok';
			}else{
				return 'error';
			}
		}
		public function mdlMostrarResponsableMunicipalidad($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT idUsuario, idPersonaUsuario, nombrePersona, apellidoPaternoPersona, apellidoMaternoPersona, dniPersona,  correoUsuario, celularUsuario, tipo_usuario.nombreTipoUsuario, nombreMunicipalidad, imagenMunicipalidad, direccionMunicipalidad, ruc FROM usuarios 
				INNER JOIN personas ON idPersonaUsuario = idPersona
				INNER JOIN tipo_usuario ON usuarios.idTipoUsuario = tipo_usuario.idTipoUsuario 
			    INNER JOIN municipalidades ON idMunicipalidadUsuario = idMunicipalidad
				WHERE idMunicipalidadUsuario = $this->idMunicipalidad AND usuarios.idTipoUsuario = 1 AND estadoUsuario = TRUE LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}

		/*----------  Agregar periodo por municipalidad  ----------*/
		public function mdlRegistrarPeriodoMunicipalidad($idMunicipalidad, $year, $periodo){
			$respuesta = ''; 
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT * FROM periodos_muni WHERE yearPeriodo = $year AND idMu = $this->idMunicipalidad LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO periodos_muni (idMu, periodo, yearPeriodo) VALUES (?,?,?)";
				$arrData = array($this->idMunicipalidad, $periodo, $year); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$respuesta = "existe";
			}
			return $respuesta;
		}

		/*----------  Mostrar Departamentos  ----------*/
		public function mdlTablaPeriodo($idMunicipalidad){
			$sql = "SELECT idPeriodosMuni, idMu, periodo, yearPeriodo FROM periodos_muni WHERE idMu = $idMunicipalidad";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}

		public function mdlMostrarPeriodoMunicipalidad($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT * FROM periodos_muni WHERE idMu = $this->idMunicipalidad AND yearperiodo = YEAR(NOW()) LIMIT 1; ";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}

		/*----------  mostrar los periodos de entrega  ----------*/
		public function mdlMostrarPeriodos($idMunicipalidad, $nombreProducto){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql ="SELECT mesEntrega, SUM(cantidadEntrega) AS total, SUM(entregados) AS totalEntregado FROM programar_entregas 
				INNER JOIN productos ON idProductoEntrega = idProducto
			    WHERE idMunicipalidadProducto = $this->idMunicipalidad AND yearEntrega = YEAR(NOW()) AND nombreProducto LIKE '$nombreProducto'
			    GROUP BY mesEntrega;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/*----------  guardar los  datos del programa  ----------*/
		public function mdlGuardarPrograma($idProducto, $mesEntrega, $cantidad, $year){
			$this->idProducto = $idProducto;
			$this->mesEntrega = $mesEntrega;
			$this->cantidad = $cantidad;
			$this->year = $year;
			$sql = "INSERT INTO programar_entregas (idProductoEntrega, mesEntrega, cantidadEntrega, yearEntrega) VALUES (?,?,?,?)";
			$arrData = array($this->idProducto, $this->mesEntrega, $this->cantidad, $this->year); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}
		/*----------  mostrar los periodos de entrega  ----------*/
		public function mdlMostrarPeriodosYear($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql ="SELECT yearEntrega, SUM(cantidadEntrega) AS total FROM programar_entregas 
				INNER JOIN productos ON idProductoEntrega = idProducto
			    WHERE idMunicipalidadProducto = $this->idMunicipalidad
			    GROUP BY yearEntrega;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}

				/*----------  mostrar los periodos de entrega  ----------*/
		public function mdlMostrarPeriodosMes($idMunicipalidad, $mes, $year, $nombreProducto){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql =" SELECT mesEntrega, SUM(cantidadEntrega) AS total FROM programar_entregas 
				INNER JOIN productos ON idProductoEntrega = idProducto
			    WHERE idMunicipalidadProducto = $this->idMunicipalidad and mesEntrega = $mes and nombreProducto LIKE '$nombreProducto' and yearEntrega = $year 
			    GROUP BY mesEntrega LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		/*----------  mostrar productos disponibles  ----------*/
		public function mdlMostrarProductosDisponibles($idMunicipalidad, $mes, $year, $nombreProducto){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql =" SELECT idProgramarEntrega, idProductoEntrega, cantidadEntrega, nombreProducto, marcaProducto, entregados FROM programar_entregas
				INNER JOIN productos ON idProductoEntrega = idProducto
				WHERE idMunicipalidadProducto = $this->idMunicipalidad AND yearEntrega = $year AND mesEntrega = $mes AND nombreProducto LIKE '$nombreProducto' AND estadoProgramar = FALSE
				ORDER BY cantidadEntrega ASC;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		public function mdlGuardarEntrega($idComite, $contarBenefComite, $mes, $year, $idNomProd, $benefId){
			$sql = "INSERT INTO entrega_producto (idComiteEntrega, numBenef, mesEntrega, yearEntrega, idNomProd, arrBeneficiarios) VALUES (?,?,?,?,?,?)";
			$arrData = array($idComite, $contarBenefComite, $mes, $year, $idNomProd, $benefId); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}
		public function mdlContarPorMes($idMunicipalidad, $idMes, $year, $idNomProd){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql ="SELECT sum(numBenef) AS total FROM entrega_producto 
				INNER JOIN comites ON idComiteEntrega = idComite
				INNER JOIN localidades ON idLocalidadComite = idLocalidad
				WHERE mesEntrega = $idMes AND yearEntrega = $year AND idMunicipalidad = $this->idMunicipalidad AND idNomProd = $idNomProd";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		public function mdlMostrarComites($idMunicipalidad, $idMes, $year, $idNomProd){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql ="SELECT idComiteEntrega, idEntrega, nombreLocalidad, nombreComite, numBenef, idNomProd FROM entrega_producto 
				INNER JOIN comites ON idComiteEntrega = idComite
				INNER JOIN localidades ON idLocalidadComite = idLocalidad
				WHERE mesEntrega = $idMes AND yearEntrega = $year AND idMunicipalidad = $this->idMunicipalidad AND  idNomProd = $idNomProd ORDER BY idEntrega;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		public function mdlVerDisponibilidad($idMunicipalidad, $year, $mes, $estado){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql ="SELECT COUNT(idProgramarEntrega) AS total FROM programar_entregas 
				INNER JOIN productos ON idProductoEntrega = idProducto
			    WHERE idMunicipalidadProducto = $this->idMunicipalidad AND estadoProgramar = $estado AND mesEntrega >= $mes AND yearEntrega >= $year;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;	
		}

		public function mdlMostrarPadron($idMunicipalidad, $idComite, $idMes, $year){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql ="SELECT arrBeneficiarios, idNomProd FROM entrega_producto 
				INNER JOIN comites ON idComiteEntrega = idComite
				INNER JOIN localidades ON idLocalidadComite = idLocalidad
				WHERE idComiteEntrega = $idComite AND mesEntrega = $idMes AND yearEntrega = $year AND idMunicipalidad = $this->idMunicipalidad
				ORDER BY idEntrega;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
	}