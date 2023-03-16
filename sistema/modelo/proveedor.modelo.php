<?php 
require_once 'consultas.php';
Class ModeloProveedor{
	private $nombreProveedor;
	private $rucProveedor;
	private $direccionProveedor;
	private $representanteProveedor;
	private $celularProveedor;
	private $correoProveedor;
	private $idMunicipalidad;
	private $idProveedor;

	public function __construct(){
		$this->consulta = new Consultas();
	}
	/*----------  Agregar proveedor  ----------*/
	public function mdlAgregarProveedor($nombreProveedor, $rucProveedor, $direccionProveedor, $representanteProveedor, $celularProveedor, $correoProveedor, $idMunicipalidad){
		$this->nombreProveedor = $nombreProveedor;
		$this->rucProveedor = $rucProveedor;
		$this->direccionProveedor = $direccionProveedor;
		$this->representanteProveedor = $representanteProveedor;
		$this->celularProveedor = $celularProveedor;
		$this->correoProveedor = $correoProveedor;
		$this->idMunicipalidad = $idMunicipalidad;
		$sql = "SELECT COUNT(*) as totalProveedores FROM proveedores WHERE rucProveedor = '$this->rucProveedor' AND idMunicipalidadProveedor = '$this->idMunicipalidad'";
		$respuesta = $this->consulta->select($sql);
		if($respuesta['totalProveedores'] == 0){
			$sql = "INSERT INTO proveedores(nombreProveedor, rucProveedor, direccionProveedor, representanteProveedor, telefonoProveedor, correoProveedor, idMunicipalidadProveedor) VALUES (?,?,?,?,?,?,?)";
			$arrData = array($this->nombreProveedor, $this->rucProveedor, $this->direccionProveedor, $this->representanteProveedor, $this->celularProveedor, $this->correoProveedor, $this->idMunicipalidad); 
			$respuesta = $this->consulta->insert($sql, $arrData);	
		}else{
			$respuesta = 'existe';
		}
		return $respuesta;
	}
	/*----------  Buscar proveedores  ----------*/
	public function mdlMostrarProveedores($idMunicipalidad){
		$this->idMunicipalidad = $idMunicipalidad;
		$sql = "SELECT * FROM proveedores WHERE idMunicipalidadProveedor = $this->idMunicipalidad 
				ORDER BY idProveedor";
		$respuesta = $this->consulta->selectAll($sql);
		return $respuesta;
	}
	/*----------  proveedoresActivos  ----------*/
	public function mdlMostrarProveedoresActivos($idMunicipalidad){
		$this->idMunicipalidad = $idMunicipalidad;
		$sql = "SELECT * FROM proveedores WHERE idMunicipalidadProveedor = $this->idMunicipalidad AND estadoProveedor = TRUE
				ORDER BY idProveedor";
		$respuesta = $this->consulta->selectAll($sql);
		return $respuesta;
	}
	/*----------  Editar un campo de un proveedor  ----------*/
	public function mdlEditarCampoProveedor($item, $valor, $idProveedor){
		$this->idProveedor = $idProveedor;
		$sql = "UPDATE proveedores SET $item = ? WHERE idProveedor = $this->idProveedor";
		$arrData = array($valor); 
		$respuesta = $this->consulta->update($sql, $arrData);
		return $respuesta;
	}
	/*----------  Mostrar un proveedor  ----------*/
	public function mdlMostrarProveedor($atributo, $valor, $idMunicipalidad){
		$this->idMunicipalidad = $idMunicipalidad;
		$sql = "SELECT * FROM proveedores WHERE $atributo = '$valor' AND idMunicipalidadProveedor = $this->idMunicipalidad LIMIT 1";
		$respuesta = $this->consulta->select($sql);
		return $respuesta;
	}
	/*----------  Editar un proveedor  ----------*/
    public	function mdlEditarProveedor($representanteProveedor, $correoProveedor, $celularProveedor, $idProveedor){
		$this->representanteProveedor = $representanteProveedor;
		$this->correoProveedor = $correoProveedor;
		$this->celularProveedor = $celularProveedor;
		$this->idProveedor = $idProveedor;
		$sql = "UPDATE proveedores SET  representanteProveedor = ?, telefonoProveedor = ?, correoProveedor = ? 
				WHERE idProveedor = $this->idProveedor";
		$arrData = array($this->representanteProveedor, $this->correoProveedor, $this->celularProveedor); 
		$respuesta = $this->consulta->update($sql, $arrData);
		if ($respuesta) {
			$respuesta = 'ok';
		}
		return $respuesta;
	}
}