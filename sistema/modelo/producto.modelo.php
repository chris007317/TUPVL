<?php 
require_once 'consultas.php';
Class ModeloProducto{
	private $nombreProducto;
	private $codigoProducto;
	private $descripcionProducto;
	private $precio;
	private $peso;
	private $marcaProducto;
	private $ruta;
	private $idMunicipalidad;

	public function __construct(){
		$this->consulta = new Consultas();
	}
	/*----------  Agregar un producto  ----------*/
	function mdlAgregarProducto($nombreProducto, $codigoProducto, $descripcionProducto, $precio, $peso, $marcaProducto, $ruta, $idMunicipalidad){
		$this->nombreProducto = $nombreProducto;
		$this->codigoProducto = $codigoProducto;
		$this->descripcionProducto = $descripcionProducto;
		$this->precio = $precio;
		$this->peso = $peso;
		$this->marcaProducto = $marcaProducto;
		$this->ruta = $ruta;
		$this->idMunicipalidad = $idMunicipalidad;
		$sql = "SELECT * FROM productos WHERE codigoProducto = '$this->codigoProducto' AND idMunicipalidadProducto = '$this->idMunicipalidad' LIMIT 1";
		$respuesta = $this->consulta->select($sql);
		if (empty($respuesta)) {
			$sql = "INSERT INTO productos(nombreProducto, codigoProducto, descripcionProducto, precioUnidad, pesoUnidad, marcaProducto, imgProducto, idMunicipalidadProducto) VALUES (?,?,?,?,?,?,?,?)";
			$arrData = array($this->nombreProducto, $this->codigoProducto, $this->descripcionProducto, $this->precio, $this->peso, $this->marcaProducto, $this->ruta, $this->idMunicipalidad); 
			$respuesta = $this->consulta->insert($sql, $arrData);
		}else{
			$respuesta = "existe";
		}
		return $respuesta;
	}
	/*----------  Mostrar productos  ----------*/
	public function mdlContarProductos($idMunicipalidad, $valor){
		$this->idMunicipalidad = $idMunicipalidad;
		$respuesta;
		if($valor == ''){
			$sql = "SELECT COUNT(*) as totalProductos FROM productos WHERE idMunicipalidadProducto = $this->idMunicipalidad";
			$respuesta = $this->consulta->select($sql);
		}else{
			$sql = "SELECT COUNT(*) as totalProductos FROM productos 
				WHERE nombreProducto LIKE '%$valor%' OR codigoProducto LIKE'%$valor%' AND idMunicipalidadProducto = $this->idMunicipalidad";
			$respuesta = $this->consulta->select($sql);
		}
		return $respuesta;
	}
	/*----------  Contar Productos  ----------*/
	public function mdlMostrarProductos($valor, $idMunicipalidad, $pagina){
		$respuesta = '';
		$this->idMunicipalidad = $idMunicipalidad;
		if ($valor=='') {
			$sql = "SELECT * FROM productos WHERE idMunicipalidadProducto = $this->idMunicipalidad 
				ORDER BY idProducto DESC LIMIT $pagina, 6";
			$respuesta = $this->consulta->selectAll($sql);
		}else{
			$sql = "SELECT * FROM productos 
				WHERE (nombreProducto LIKE '%$valor%' OR codigoProducto LIKE'%$valor%') AND idMunicipalidadProducto = $this->idMunicipalidad
				ORDER BY idProducto DESC LIMIT $pagina, 6";
			$respuesta = $this->consulta->selectAll($sql);
		}
		return $respuesta;
	}
	/*----------  Mostrar un producto  ----------*/
	public function mdlMostrarProducto($atributo, $valor, $idMunicipalidad){
		$this->idMunicipalidad = $idMunicipalidad;
		$sql = "SELECT * FROM productos WHERE idProducto = '$valor' AND idMunicipalidadProducto = $this->idMunicipalidad LIMIT 1";
		$respuesta = $this->consulta->select($sql);
		return $respuesta;
	}
	/*----------  Mostrar lista productos  ----------*/
	public function mdlMostrarListaProductos($idMunicipalidad){
		$this->idMunicipalidad = $idMunicipalidad;
		$sql = "SELECT idProducto, nombreProducto, marcaProducto FROM productos WHERE estado = TRUE AND idMunicipalidadProducto = $this->idMunicipalidad";
		$respuesta = $this->consulta->selectAll($sql);
		return $respuesta;
	}
	/*----------  Editar un producto  ----------*/
    public	function mdlEditarProducto($idProducto, $codigoProducto, $descripcionProducto, $precio, $peso, $marcaProducto, $ruta, $idMunicipalidad){
		$this->idProducto = $idProducto;
		$this->codigoProducto = $codigoProducto;
		$this->descripcionProducto = $descripcionProducto;
		$this->precio = $precio;
		$this->peso = $peso;
		$this->marcaProducto = $marcaProducto;
		$this->ruta = $ruta;
		$this->idMunicipalidad = $idMunicipalidad;
		$sql = "SELECT * FROM productos 
				WHERE codigoProducto = '$this->codigoProducto' AND idMunicipalidadProducto = $this->idMunicipalidad AND idProducto != $this->idProducto LIMIT 1";
		$respuesta = $this->consulta->select($sql);
		if (empty($respuesta)) {
			$sql = "UPDATE productos SET  codigoProducto = ?, descripcionProducto = ?, precioUnidad = ?, pesoUnidad = ?, marcaProducto = ?, imgProducto = ?   WHERE idProducto = $this->idProducto";
			$arrData = array($this->codigoProducto, $this->descripcionProducto, $this->precio, $this->peso, $this->marcaProducto, $this->ruta); 
			$respuesta = $this->consulta->update($sql, $arrData);
			if ($respuesta) {
				$respuesta = 'ok';
			}
		}else{
			$respuesta = "existe";
		}
		return $respuesta;
	}
	/*----------  Editar un campo de un producto  ----------*/
	public function mdlEditarCampoProducto($item, $valor, $idProducto){
		$this->idProducto = $idProducto;
		$sql = "UPDATE productos SET $item = ? WHERE idProducto = $this->idProducto";
		$arrData = array($valor); 
		$respuesta = $this->consulta->update($sql, $arrData);
		return $respuesta;
	}
	/*----------  consulta par el reporte  ----------*/
	public function mdlReporteProducto($idMunicipalidad){
		$this->idMunicipalidad = $idMunicipalidad;
		$sql = "SELECT codigoProducto, descripcionProducto, nombreProducto, marcaProducto, nombreProveedor, rucProveedor, cantidad, fechaRecepcion, 
		 precioUnidad, pesoUnidad, nombreUsuario, nombrePersona, apellidoPaternoPersona, apellidoMaternoPersona
			FROM entradas 
			INNER JOIN productos ON idProductoEntrada = idProducto
			INNER JOIN proveedores ON idProveedorEntrada = idProveedor
			INNER JOIN usuarios ON idUsuarioEntrada = idUsuario
			INNER JOIN personas ON idPersonaUsuario = idPersona
			WHERE idMunicipalidadEntrada = $this->idMunicipalidad ORDER BY fechaRecepcion ASC;";
		$respuesta = $this->consulta->selectAll($sql);
		return $respuesta;
	}
}
