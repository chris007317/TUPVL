<?php 
	require_once 'consultas.php';
	Class ModeloTipoBeneficiario{
		private $idTipoBeneficiario;
		private $nombreTipoBeneficiario;
		private $descripcionTipoBeneficiario;
		private $consulta;

		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  Agregar tipo de beneficiario  ----------*/
		public function mdlRegistrarTipoBeneficiario($nombreTipoBeneficiario, $descripcionTipoBeneficiario){
			$this->nombreTipoBeneficiario = $nombreTipoBeneficiario;
			$this->descripcionTipoBeneficiario = $descripcionTipoBeneficiario;
			$sql = "INSERT INTO tipo_beneficiario ( nombreTipoBeneficiario, descripcion) VALUES (?,?)";
			$arrData = array($this->nombreTipoBeneficiario, $this->descripcionTipoBeneficiario); 
			$respuesta = $this->consulta->insert($sql, $arrData);
			return $respuesta;
		}
		/*----------  Mostrar tipo de beneficiario  ----------*/
		public function mdlMostrarTipoBeneficiarios(){
			$sql = "SELECT * FROM tipo_beneficiario WHERE estadoTipoBeneficiario = TRUE ORDER BY nombreTipoBeneficiario ASC";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
		/*----------  Editar tipo de beneficiario  ----------*/
		public function mdlEditarTipoBeneficiario($descripcionTipoBeneficiario, $idTipoBeneficiario){
			$this->descripcionTipoBeneficiario = $descripcionTipoBeneficiario;
			$this->idTipoBeneficiario = $idTipoBeneficiario;
			$sql = "UPDATE tipo_beneficiario SET descripcion = ? WHERE idTipoBeneficiario = $this->idTipoBeneficiario";
			$arrData = array($this->descripcionTipoBeneficiario); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		/*----------  buscar tipo de beneficiario  ----------*/
		public function mdlMostrarTipoBeneficiario($item, $valor){
			$sql = "SELECT * FROM tipo_beneficiario WHERE $item = '$valor' AND estadoTipoBeneficiario = TRUE LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;	
		}
	}