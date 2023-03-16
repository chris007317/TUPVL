<?php 
	require_once 'consultas.php';
	Class ModeloPersona{
		private $dni;
		private $nombrePersona;
		private $apellidoMaterno;
		private $apellidoPaterno;
		private $idPersona;

		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  mostrar persona  ----------*/
		public function mdlMostrarPersona($item, $valor){
			$sql = "SELECT * FROM personas  WHERE $item = '$valor' LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		/*----------  agregar persona  ----------*/
		public function mdlRegistrarPersona($nombrePersona, $apellidoMaterno, $apellidoPaterno, $dni){
			$this->nombrePersona = $nombrePersona;
			$this->apellidoMaterno = $apellidoMaterno;
			$this->apellidoPaterno = $apellidoPaterno;
			$this->dni = $dni;
			$sql = "SELECT idPersona FROM personas WHERE dniPersona = '$this->dni' LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO personas (nombrePersona, apellidoMaternoPersona, apellidoPaternoPersona, dniPersona) VALUES(?,?,?,?)";
				$arrData = array($this->nombrePersona, $this->apellidoMaterno, $this->apellidoPaterno, $this->dni); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$respuesta = $respuesta['idPersona'];
			}
			return $respuesta;
		}
		/*----------  editar un campo de la person  ----------*/
		public function mdlEditarCampoPersona($item, $valor, $idPersona){
			$this->idPersona = $idPersona;
			$sql = "UPDATE personas SET $item = ? WHERE idPersona = $this->idPersona";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
	}