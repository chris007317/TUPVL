<?php 
	class Conexion{
		private $host = 'localhost';
		private $usuario = '';
		private $contra = '';
		private $db = '';
		private $conect;
		
		public function __construct($db){
			
			$this->db = $db['bd'];
			$this->usuario = $db['user'];
			$this->contra = $db['contra'];
			$conectionString = "mysql:host=".$this->host.";dbname=".$this->db.";charset=utf8";
			try{
				$this->conect = new PDO($conectionString, $this->usuario, $this->contra);
				$this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				$this->conect = 'Error de conexión';
				echo "ERROR: ".$e->getMessage();
			}
		}

		public function conect(){
			return $this->conect;
		}
	}
 