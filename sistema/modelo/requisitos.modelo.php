<?php 
	require_once 'consultas.php';
	Class ModeloRequsitos{
		private $idRequisito;
		private $nombreRequisito;
		private $descripcionRequisito;
		private $consulta;

		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  Agregar requisitos  ----------*/
		public function mdlRegistrarRequisito($nombreRequisito, $descripcionRequisito){
			$this->nombreRequisito = $nombreRequisito;
			$this->descripcionRequisito = $descripcionRequisito;
			$sql = "INSERT INTO requisitos( nombreRequisito, descripcionRequisito) VALUES (?,?)";
			$arrData = array($this->nombreRequisito, $this->descripcionRequisito); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}
		/*----------  Mostrar Requisitos  ----------*/
		public function mdlMostrarRequisitos(){
			$sql = "SELECT * FROM requisitos WHERE estadoRequisito = TRUE";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/*----------  Editar Requisitos  ----------*/
		public function mdlEditarRequisito($descripcionRequisito, $idRequisito){
			$this->descripcionRequisito = $descripcionRequisito;
			$this->idRequisito = $idRequisito;
			$sql = "UPDATE requisitos SET descripcionRequisito = ? WHERE idRequisito = $this->idRequisito";
			$arrData = array($this->descripcionRequisito); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		/*----------  buscar requisito  ----------*/
		public function mdlMostrarRequisito($item, $valor){
			$sql = "SELECT * FROM requisitos WHERE $item = '$valor' AND estadoRequisito = TRUE LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;	
		}
	}