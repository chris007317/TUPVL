<?php 
	require_once 'consultas.php';
	Class ModeloInscripcion{
	
		/*----------  Mostrar Departamentos  ----------*/
		static public function mdlMostrarDepartamento(){
            $bd1 = 'jun23tud_tupvl_db';
	        $user1 = 'jun23tud_tupvl';
	        $contra1 = 'tupvl_2021Chris0073';
			$consulta = new Consultas($bd1, $user1, $contra1);
			$sql = "SELECT * FROM departamentos";
			$respuesta = $consulta->selectAll($sql);
			return $respuesta;
			
		}
		/*----------  Mostrar Provincias por Departamentos  ----------*/
		static public function mdlMostrarProvincias($idDepartamento){
			$valor = $idDepartamento;
            $bd1 = 'jun23tud_tupvl_db';
	        $user1 = 'jun23tud_tupvl';
	        $contra1 = 'tupvl_2021Chris0073';
			$consulta = new Consultas($bd1, $user1, $contra1);
			$sql = "SELECT * FROM provincias WHERE idDepartamento = $valor";
			$respuesta = $consulta->selectAll($sql);
			return $respuesta;
			
		}
		/*----------  Mostrar Distritos por Provincia  ----------*/
		static public function mdlMostrarDistritos($idProvincia){
			$valor = $idProvincia;
            $bd1 = 'jun23tud_tupvl_db';
	        $user1 = 'jun23tud_tupvl';
	        $contra1 = 'tupvl_2021Chris0073';
			$consulta = new Consultas($bd1, $user1, $contra1);
			$sql = "SELECT * FROM distritos WHERE idProvincia = $valor";
			$respuesta = $consulta->selectAll($sql);
			return $respuesta;
		}
		/*----------  Registrar Responsable  ----------*/
		static public function mdlRegistrarResponsable($dniResponsable, $apellidoPaterno, $apellidoMaterno, $nombres, $celularResponsable, $correoResponsable){
			$dni = $dniResponsable;
			$bd2 = 'jun23tud_tupvl_admin';
	        $user2 = 'jun23tud_tupvl';
	        $contra2 = 'tupvl_2021Chris0073';
			$consulta = new Consultas($bd2, $user2, $contra2);
			$sql = "SELECT * FROM responsables WHERE dni = '$dni' LIMIT 1";
			$respuesta = $consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO responsables (apellidoPaterno, apellidoMaterno, nombres, dni, correo, celular) VALUES(?,?,?,?,?,?)";
				$arrData = array($apellidoPaterno, $apellidoMaterno, $nombres, $dni, $correoResponsable, $celularResponsable); 
				$respuesta = $consulta->insert($sql, $arrData);
			}else{
				$respuesta = 'existe';
			}
			return $respuesta;
		}
		/*----------  Resgistrat municipalidad  ----------*/
		static public function mdlRegistrarMunicipalidad($idDistritoMuni, $nombreMunicipalidad, $ruta, $direccionMunicipalidad, $ruc, $idResponsable){
			$bd2 = 'jun23tud_tupvl_admin';
	        $user2 = 'jun23tud_tupvl';
	        $contra2 = 'tupvl_2021Chris0073';
			$consulta = new Consultas($bd2, $user2, $contra2);
			$sql = "INSERT INTO propuesta (idDistrito, nombreMunicipalidad, imagenMunicipalidad, direccion, ruc, idRes) VALUES(?,?,?,?,?,?)";
			$arrData = array($idDistritoMuni, $nombreMunicipalidad, $ruta, $direccionMunicipalidad, $ruc, $idResponsable); 
			$respuesta = $consulta->insert($sql, $arrData);
			return $respuesta;
		}
		/*----------  Buscar Municipalidad  ----------*/
		static public function mdlBuscarMunicipalidad($ruc){
			$bd2 = 'jun23tud_tupvl_admin';
	        $user2 = 'jun23tud_tupvl';
	        $contra2 = 'tupvl_2021Chris0073';
			$consulta = new Consultas($bd2, $user2, $contra2);
			$sql = "SELECT * FROM propuesta WHERE ruc = '$ruc' LIMIT 1";
			$respuesta = $consulta->select($sql);
			return $respuesta;	
		}
	}