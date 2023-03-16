<?php 
	require_once 'consultas.php';
	Class ModeloDireccion{
		private $direccion;
		private $numero;
		private $descripcion;
		private $idDistrito;
		private $idMunicipalidad;
		private $idDireccion;

		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  mostrar persona  ----------*/
		public function mdlMostrarCiudadDireccion($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT nombreDepartamento, nombreProvincia, nombreDistrito, distritos.idDistrito FROM municipalidades 
				INNER JOIN distritos ON idDistritoMunicipalidad = idDistrito
		        INNER JOIN provincias ON distritos.idProvincia = provincias.idProvincia
		        INNER JOIN departamentos ON provincias.idDepartamento = departamentos.idDepartamento
				WHERE idMunicipalidad = $this->idMunicipalidad LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		/*----------  Agregar direccion  ----------*/
		public function mdlAgregarDireccion($direccion, $numero, $descripcion, $idDistrito){
			$this->direccion = $direccion;
			$this->numero = $numero;
			$this->descripcion = $descripcion;
			$this->idDistrito = $idDistrito;
			$sql = "INSERT INTO direccion(nombreDireccion, numero, descripcion, idDistrito) VALUES (?,?,?,?)";
			$arrData = array($this->direccion, $this->numero, $this->descripcion, $this->idDistrito); 
			$respuesta = $this->consulta->insert($sql, $arrData);	
			return $respuesta;
		}
		/*----------  mostrar departamento  ----------*/
		public function mdlMostrarDepartamentos(){
			$sql = "SELECT idDepartamento,nombreDepartamento FROM departamentos";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/*----------  mostrar provincias  ----------*/
		public function mdlMostrarProvincias($idDepartamento){
			$sql = "SELECT idProvincia AS valor, nombreProvincia AS nombre FROM provincias WHERE idDepartamento = $idDepartamento";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/*----------  mostrar distritos  ----------*/
		public function mdlMostrarDistritos($idProvincia){
			$sql = "SELECT idDistrito AS valor, nombreDistrito AS nombre FROM distritos WHERE idProvincia = $idProvincia";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/*----------  mostrar direccion  ----------*/
		public function mdlMostrarDireccion($idDireccion){
			$this->idDireccion = $idDireccion;
			$sql = "SELECT direccion.*, nombreDistrito, distritos.idProvincia, nombreProvincia, provincias.idDepartamento, nombreDepartamento FROM direccion 
				INNER JOIN distritos ON direccion.idDistrito = distritos.idDistrito
			    INNER JOIN provincias ON distritos.idProvincia = provincias.idProvincia
			    INNER JOIN departamentos ON provincias.idDepartamento = departamentos.idDepartamento 
			    WHERE idDireccion = $this->idDireccion";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;	
		}
		/*----------  editar campos de una direccion  ----------*/
		public function mdlEditarDireccion($direccion, $numero, $descripcion, $idDistrito, $idDireccion){
			$this->direccion = $direccion;
			$this->numero = $numero;
			$this->descripcion = $descripcion;
			$this->idDistrito = $idDistrito;
			$this->idDireccion = $idDireccion;
			$sql = "UPDATE direccion  SET  nombreDireccion = ?, numero = ?, descripcion = ?, idDistrito = ? 
					WHERE idDireccion = $this->idDireccion";
			$arrData = array($this->direccion, $this->numero, $this->descripcion, $this->idDistrito); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
	}