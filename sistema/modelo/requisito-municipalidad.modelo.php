<?php 
	require_once 'consultas.php';
	Class ModeloRequisitoMunicipalidad{
		private $idRequisitoMuni;
		private $idMunicipalidad;
		private $idRequisito;
		private $idTipoBeneficiario;
		private $estado;
		private $consulta;

		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  Agregar requsito por municipalidad  ----------*/
		public function mdlRegistrarRequisitoMunicipalidad($idMunicipalidad, $idRequisito, $idTipoBeneficiario){
			$respuesta = ''; 
			$this->idMunicipalidad = $idMunicipalidad;
			$this->idRequisito = $idRequisito;
			$this->idTipoBeneficiario = $idTipoBeneficiario;			
			$sql = "SELECT * FROM requisito_municipalidad WHERE idReq = '$this->idRequisito' AND idRequisitoTipoBenef = '$this->idTipoBeneficiario' LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO requisito_municipalidad (idRequisitoMuni, idReq, idRequisitoTipoBenef) VALUES (?,?,?)";
				$arrData = array($this->idMunicipalidad, $this->idRequisito, $this->idTipoBeneficiario); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$respuesta = "existe";
			}
			return $respuesta;
		}
		/*----------  Mostrar requisitos por tipo de beneficiario  ----------*/
		public function mdlMostrarRequisitoMunicipalidad($idRequisitoMuni, $idRequisitoTipoBenef){
			$this->idMunicipalidad = $idRequisitoMuni;
			$this->idTipoBeneficiario = $idRequisitoTipoBenef;			
			$sql = "SELECT idReMuni, nombreRequisito, descripcionRequisito, requisito_municipalidad.estado FROM requisito_municipalidad 
				INNER JOIN requisitos ON idReq = idRequisito
			    WHERE idRequisitoMuni = $this->idMunicipalidad AND idRequisitoTipoBenef = $this->idTipoBeneficiario AND estadoRequisito = TRUE
			    ORDER BY idReMuni DESC";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;	
		}
		/*----------  Editar estado del requisito  ----------*/
		public function mdlEditarRequisitoMunicipalidad($item, $valor, $idReMuni){
			$this->idRequisitoMuni = $idReMuni;
			$sql = "UPDATE requisito_municipalidad SET $item = ? WHERE idReMuni = $this->idRequisitoMuni";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
		/*----------  Eliminar requisito  ----------*/
		public function mdlEliminarRequisitoMunicipalidad($idReMuni){
			$this->idRequisitoMuni = $idReMuni;
			$sql = "DELETE FROM requisito_municipalidad WHERE idReMuni = $this->idRequisitoMuni";
			$respuesta = $this->consulta->delete($sql);
			return $respuesta;
		}
	}