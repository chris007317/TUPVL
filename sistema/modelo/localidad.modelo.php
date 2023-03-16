<?php 
	require_once 'consultas.php';
	Class ModeloLocalidad{
		private $idLocalidad;
		private $idMunicipalidad;
		private $idTipoLocalidad;
		private $nombreLocalidad;
		private $consulta;

		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  Mostrar tipo localidad  ----------*/
		public function mdlMostrarTipoLocalidad(){
			$sql = "SELECT * FROM tipo_localidad  ORDER BY nombreTipoLocalidad ASC";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/*----------  Mostrar localidades por municipalidad  ----------*/
		public function mdlMostrarLocalidades($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT idLocalidad, nombreLocalidad, nombreTipoLocalidad, estadoLocalidad FROM localidades 
					INNER JOIN tipo_localidad ON localidades.idTipoLocalidad = tipo_localidad.idTipoLocalidad 
					WHERE idMunicipalidad = $this->idMunicipalidad ORDER BY nombreLocalidad ASC";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/*----------  Agregar requisitos  ----------*/
		public function mdlAgregarLocalidad($nombreLocalidad, $idMunicipalidad, $idTipoLocalidad){
			$this->nombreLocalidad = $nombreLocalidad;
			$this->idMunicipalidad = $idMunicipalidad;
			$this->idTipoLocalidad = $idTipoLocalidad;
			$sql = "INSERT INTO localidades(nombreLocalidad, idMunicipalidad, idTipoLocalidad) VALUES (?,?,?)";
			$arrData = array($this->nombreLocalidad, $this->idMunicipalidad, $this->idTipoLocalidad); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}
		/*----------  editar localidad por un campo  ----------*/
		public function mdlEditarLocalidad($item, $valor, $idLocalidad){
			$this->idLocalidad = $idLocalidad;
			$sql = "UPDATE localidades SET $item = ? WHERE idLocalidad = $this->idLocalidad";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		/*----------  mostrar localidad  ----------*/
		public function mdlMostrarLocalidad($idLocalidad){
			$this->idLocalidad = $idLocalidad;
			$sql = "SELECT idLocalidad, nombreLocalidad, idTipoLocalidad FROM localidades 
				WHERE idLocalidad = $this->idLocalidad LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;	
		}
		/*----------  editar localidad municipalidad  ----------*/
		public function mdlActualizarLocalidad($idLocalidad, $nombreLocalidad, $idTipoLocalidad){
			$this->idLocalidad = $idLocalidad;
			$this->idTipoLocalidad = $idTipoLocalidad;
			$this->nombreLocalidad = $nombreLocalidad;
			$sql = "SELECT * FROM localidades WHERE nombreLocalidad = '$this->nombreLocalidad' AND idLocalidad != $this->idLocalidad LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "UPDATE localidades SET nombreLocalidad = ?, idTipoLocalidad = ? WHERE idLocalidad = $this->idLocalidad";
				$arrData = array($this->nombreLocalidad, $this->idTipoLocalidad); 
				$respuesta = $this->consulta->update($sql, $arrData);
			}else{
				$respuesta = 'existe';
			}
			return $respuesta;
		}	
		/*----------  Mostrar localidades por municipalidad activas  ----------*/
		public function mdlMostrarLocalidadesActivas($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT idLocalidad, nombreLocalidad FROM localidades 
					WHERE idMunicipalidad = $this->idMunicipalidad AND estadoLocalidad = TRUE ORDER BY nombreLocalidad ASC";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}	
	}