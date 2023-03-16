<?php 
	require_once "conexion.php";
	class Consultas{
		
		public $conexion;
		private $strquery;
		private $arrDatos;
		
		function __construct($db){
			$this->conexion = new Conexion($db);
			$this->conexion = $this->conexion->conect();
		}
		//Insertar un registro
		public function insert(string $query, array $arrDatos){
			$this->strquery = $query;
			$this->arrDatos = $arrDatos;
			$insertar = $this->conexion->prepare($this->strquery);
			$respuesta = $insertar->execute($this->arrDatos);
			if ($respuesta) {
				$idInsertar = $this->conexion->lastInsertId();
			}else{
				$idInsertar = 0;
			}
			return $idInsertar;
		}
		//Buscar un registr
		public function select(string $query){
			$this->strquery = $query;
			$result = $this->conexion->prepare($this->strquery);
			$result->execute();
			$respuesta = $result->fetch(PDO::FETCH_ASSOC);
			return $respuesta;
		}
		//Buscar todos los registros
		public function selectAll(string $query){
			$this->strquery = $query;
			$result = $this->conexion->prepare($this->strquery);
			$result->execute();
			$respuesta = $result->fetchall(PDO::FETCH_ASSOC);
			return $respuesta;
		}
		//Actualizar registro
		public function update(string $query, array $arrDatos){
			$this->strquery = $query;
			$this->arrDatos = $arrDatos;
			$editar = $this->conexion->prepare($this->strquery);
			$respuesta = $editar->execute($this->arrDatos);
			return $respuesta;
		}
		//Eliminar un registro
		public function delete(string $query){
			$this->strquery = $query;
			$result = $this->conexion->prepare($this->strquery);
			$respuesta = $result->execute();
			return $respuesta;
		}
	}
