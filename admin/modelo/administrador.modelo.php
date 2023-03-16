<?php 
	require_once 'controlador/ruta.controlador.php';
	require_once 'consultas.php';
	Class ModeloAdministrador{
		public $baseDatos;
		public $nombreAdministrador;
		/*----------  Mostrar Departamentos  ----------*/
		public function mdlMostrarAdministrador($atributo, $valor){
			$this->baseDatos = ControladorRuta::ctrBdAdmin();
			$consulta = new Consultas($this->baseDatos);
			$sql = "SELECT * FROM administrador WHERE $atributo = '$valor' LIMIT 1";
			$respuesta = $consulta->select($sql);
			return $respuesta;
		}
	}