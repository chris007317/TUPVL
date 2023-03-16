<?php 
	require_once 'consultas.php';
	Class ModeloEntrada{
		private $idProducto;
		private $idProveedor;
		private $fecha;
		private $cantidad;
		private $observacion;
		private $idMunicipalidad;
		private $idUsuario;

		public function __construct(){
			$this->consulta = new Consultas();
		}
		public function mdlNuevaEntrada($idProducto, $idProveedor, $fecha, $cantidad, $observacion, $idMunicipalidad, $idUsuario){
			$this->idProducto = $idProducto;
			$this->idProveedor = $idProveedor;
			$this->fecha = $fecha;
			$this->cantidad = $cantidad;
			$this->observacion = $observacion;
			$this->idMunicipalidad = $idMunicipalidad;
			$this->idUsuario = $idUsuario;
			$sql = "INSERT INTO entradas(cantidad, fechaRecepcion, observacion, idProductoEntrada, idProveedorEntrada, idUsuarioEntrada, idMunicipalidadEntrada) VALUES (?,?,?,?,?,?,?)";
			$arrData = array($this->cantidad, $this->fecha, $this->observacion, $this->idProducto, $this->idProveedor, $this->idUsuario, $this->idMunicipalidad); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}
		/*----------  Tabla entradas  ----------*/
		public function mdlMostrarEntradas($idMunicipalidad){
			$this->idMunicipalidad = $idMunicipalidad;
			$sql = "SELECT idEntrada, nombreProducto, marcaProducto, rucProveedor, nombreProveedor, observacion, cantidad, fechaRecepcion, nombrePersona 
				FROM entradas 
				INNER JOIN productos ON idProductoEntrada = idProducto
				INNER JOIN proveedores ON idProveedorEntrada = idProveedor
				INNER JOIN usuarios ON idUsuarioEntrada = idUsuario
				INNER JOIN personas ON idPersonaUsuario = idPersona
				WHERE idMunicipalidadEntrada = $this->idMunicipalidad ORDER BY idEntrada DESC";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}		
	}